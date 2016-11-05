<template>
	<div v-show="show" transition="fade" 
	     class="CustomToast 
	     	    CustomToast--{{position | capitalize}}
	     	    CustomToast--{{type | capitalize}}">
		<div>
			{{message}}
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			type: {
				default : 'info'
			},
			timeout: {
				default : 3000,
			},
			position: {
				default : 'bottom',
			}
		},
		
		data() {
			return {
				show : false,
				message : '',
			}			
		},

		ready : function () {

		},
	
		methods : {

			showMessage : function (message) {
				this.message = message;
				this.show = true;
				this.resetOption();
			},

			showToast : function(option) {
			    this.message = option.message ? option.message : '';
			    this.timeout = option.timeout ? option.timeout : 3000;
			    this.position = option.position ? option.position : 'bottom';
				this.show = true;
				this.resetOption();
			},

			resetOption : function () {
				setTimeout(
					() => this.tick(),
					this.timeout
				)	
			},

			tick : function () {
				this.show = false;
			}
		}		
	}
</script>
<style>

.CustomToast {
    min-width: 250px;
    margin-left: -125px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 9999;
    left: 50%;
    font-size: 17px;
}

.CustomToast--Top {
	top: 10px;
}

.CustomToast--Bottom {
	bottom: 30px;
}

.CustomToast--Success {
	background-color : green;
}

.CustomToast--Info {
	background-color : #333;
}

.CustomToast--Warning {
	background-color : yellow;
}

.CustomToast--Error {
	background-color : red;
}


.fade-transition {
  display: inline-block; /* otherwise scale animation won't work */
}

.fade-enter {
  animation: fadein .5s;
}
.fade-leave {
  animation: fadeout .5s;
}

@-webkit-keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 0; opacity: 0;}
}

</style>