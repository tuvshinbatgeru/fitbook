<template>
	<div>
		<h3>Club Training</h3>
		<p><a @click="showAddTraining = true" data-open="revealTraining" class="button success">
				<i class="fa fa-plus"></i>Add Training
		   </a></p>

		<custom-modal title="Add Training" usage="_add-training" :show.sync="showAddTraining">
			<div slot="body">
				<form method="POST" accept="">
					<ul class="tabs" data-tabs id="example-tabs">
					  <li class="tabs-title is-active"><a href="#main" aria-selected="true">Info</a></li>
					  <li class="tabs-title"><a href="#photos">Photos</a></li>
					  <li class="tabs-title"><a href="#teacher">Teacher</a></li>
				    </ul>
				  <div class="tabs-content" data-tabs-content="example-tabs">
					  <div class="tabs-panel is-active" id="main">
					    <div class="row">
						    <div class="medium-6 columns">
						      <label>Training name
						        <input type="text" placeholder="fill training name">
						      </label>
						    </div>
						    <div class="medium-6 columns">
						      <label>Description
						        <textarea type="text" placeholder="Description ...">
						        </textarea>
						      </label>
						    </div>
						</div>
						<div class="row">
						  	<div class="medium-6 columns">
						  	  <label> Priceless
						  		<input type="checkbox" name="priceless">
						  	  </label>
						  	</div>
						  	<div class="medium-6 columns">
						  	  <label>Price
						  	  	<input type="text" placeholder="price">
						  	  </label>
						  	</div>
						</div>
					  </div>
					  <div class="tabs-panel" id="teacher">
	  	  	  		  	<teachers :clubid="clubid"></teachers>
					  </div>
					  <div class="tabs-panel" id="photos">
						  <div class="picture-list">
						  	<div class="row small-up-2 medium-up-3 large-up-4">
						  		<br>
							  	<div class="column">
								  	<div class="figure">
					                    <img src="https://graph.facebook.com/v2.6/1098895463504115/picture?width=1920" alt="Jeffrey Way" height="120" width="120" style="border-radius:4px;">
					                    <div class="figcaption">
					                        <a class="btn-floating red" style="left: 25%;">
					                        	<i class="fa fa-trash"></i>
					                        </a>
					                    </div>
					                </div>
							  	</div>

							  	<div class="column">
								  	<div class="figure">
					                    <img src="https://graph.facebook.com/v2.6/1098895463504115/picture?width=1920" alt="Jeffrey Way" height="120" width="120" style="border-radius:4px;">
					                    <div class="figcaption">
					                        <a class="btn-floating red" style="left: 25%;">
					                        	<i class="fa fa-trash"></i>
					                        </a>
					                    </div>
					                </div>
							  	</div>

							  	<div class="column">
								  	<div class="figure">
					                    <img src="https://graph.facebook.com/v2.6/1098895463504115/picture?width=1920" alt="Jeffrey Way" height="120" width="120" style="border-radius:4px;">
					                    <div class="figcaption">
					                        <a class="btn-floating red" style="left: 25%;">
					                        	<i class="fa fa-trash"></i>
					                        </a>
					                    </div>
					                </div>
							  	</div>
							  	
							  	<div class="column">
								  	<div class="figure">
					                    <div class="figcaption" style="opacity:1;">
					                        <a class="btn-floating red" style="left: 25%;">
					                        	<i class="fa fa-plus"></i>
					                        </a>
					                    </div>
					                </div>
							  	</div>
							</div>
						  </div>
					  </div>
				  </div>
				</form>
			</div>
		</custom-modal>

		<label>Search Training
        	<input type="text" placeholder="search ..." />
        </label>
		<ul v-if="training == null">
			<li></li>
		</ul>
		
		<h3 v-else>There is no training registered !</h3>
	<div>
</template>

<script>

	import teachers from '../.././components/teachers.vue';
	import CustomModal from '../.././components/CustomModal.vue'; 

	export default {
		props: { 
			clubid : {},
		},

		data() {
			return {
				training : [],
				showAddTraining : false,
			}
		},
		
		ready : function () {
			$(document).foundation();
		},

		events : {
			'modal-saved' : function($request) {
				switch($request) 
				{
					case "_add-training" : 
						this.saveTraining();
						break;
					case "_somethingelse" :
						break;	
					default : 
						break;
				}
			},
		},

		methods : {
			saveTraining : function() {
				alert('training saved :D !');
				this.showAddTraining = false;
			}
		},

		components : {
			teachers, CustomModal
		}
	}
</script>
	
<style lang="scss">

.picture-list {
	background-color : #5fcf80;
	border-radius: 4px;
}

.add-button {
	height:120px; 
	width:120px; 
	background-color: #fff; 
	border-radius:4px; 
	border:1px solid #53BBB4;
}

.figure {
	margin:0 10px 10px 0;
	height:120px; 
	width:120px; 
	position:relative;

	&:hover {
    	.figcaption {
    		opacity: 1;
    	}
    }
}

.figcaption {
	border-radius: 4px;
	background-color: rgba(58, 52, 42, 0.7);
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    color: #fff;
    padding: 0 25px;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    transition: all 0.25s;
    opacity: 0;
}

//search

.gh-search-submit {
    opacity: 0.75;
    z-index: 9999;
    background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…KCUM1LjE1NCwxMi44NTUsMi44MjQsMTAuNTI3LDIuODI0LDcuNjY2eiIvPg0KPC9zdmc+DQo=");
}

.gh-search-reset.show {
    cursor: pointer;
    z-index: 9999;
    opacity: 1;
    -webkit-transform: translateX(0px);
    -ms-transform: translateX(0px);
    transform: translateX(0px);
    -webkit-transition-delay: .2s;
    transition-delay: .2s;
}

</style>