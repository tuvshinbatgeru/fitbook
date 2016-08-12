<template>
	<div class="reveal" id="customModal" data-reveal data-animation-in="slide-in-up" data-animation-out="slide-out-down">
		<div class="modal-container">
			<div class="modal-header">
				<slot name="header">
					<div class="row small-up-3 medium-up-3 large-up-3">
					  <div class="columns">
					  	<button @click="modalClose" class="close-button" type="button">
							<span class="fa fa-times" aria-hidden="true"></span>
						</button>
					  </div>
					  <div class="columns">
					  	<button @click="modalSave" class="save-button" type="button">
					    	<span aria-hidden="true" class="fa fa-check"></span>
					    </button>
					  </div>
					</div>	
					<div class="row" style="height:50px; text-align: center;">
						<h4 style="color:#5fcf80;">{{title}}</h4>
					</div>
				</slot>
			<div>
			<div class="modal-body">
	          <slot name="body">
	            default body
	          </slot>
	        </div>

	        <div class="modal-footer">
	          <slot name="footer">
	            default footer
	          </slot>
	        </div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			title : { default: '' },
			usage : { default: 'questionable'},
			show: {
		      type: Boolean,
		      required: true,
		      twoWay: true,
		      default : false,    
		    },
		},

		ready : function () {
			this.modal = new Foundation.Reveal($('#customModal'));
			$(window).on('closed.zf.reveal', this.modalClose);
		},

		methods : {
			modalClose : function () {
				this.show = false;
			},

			modalSave : function() {
				this.$dispatch('modal-saved', this.usage);
			}
		},

		watch : {
		    show : function(value) {
		       value ? this.modal.open() : this.modal.close();
		    }
		},
	}
</script>
<style>
</style>