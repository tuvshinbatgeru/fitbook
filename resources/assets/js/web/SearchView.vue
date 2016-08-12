<script>
	import SearchTooltip from '.././components/SearchTooltip.vue';
	/*import SearchSettings from '.././settings/SearchSettings.js'*/
	/*var SearchSettings = require('.././settings/SearchSettings.js');*/

	export default {

		props: { 
			title : { default : 'test' },
		},

		data() {
			return {
				show: true,
				map: {},
				me : null,
				currentPos : null,
				circleTool : {},
				clubs : [],
				clubMarkers : [],
				tooltipHover : false,
				zoom : 16,
				bounds : null,
				center : { lat: 47.9118309, lng: 106.8276077 },
				searchOptions : null,
			}
		},

		ready : function () {
			this.init()
		},

		methods : {

			findMe : function () {
				this.getGeolocation();
			},

			init: function() {
				this.map = new google.maps.Map(document.getElementById('map'), {
		          center: this.center,
		          zoom: this.zoom,
		          minZoom: 13,
		          mapTypeControlOptions: {
		              style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
		              position: google.maps.ControlPosition.BOTTOM_CENTER
		          },
		        });

		        this.circleTool = new google.maps.Circle({
		            strokeColor: '#FF0000',
		            strokeOpacity: 0.8,
		            strokeWeight: 2,
		            fillColor: '#FF0000',
		            fillOpacity: 0.35,
		            map: this.map,
		            center: {lat: 47.9118309, lng: 106.8276077},
		            radius: 100,
		            editable : true,
		            draggable : true,
		        });	

		        this.searchOptions = {
		            useCircleDetector: true,
		        };

			},

			getGeolocation : function () {
				if (navigator.geolocation) 
		        {
		          	navigator.geolocation.getCurrentPosition(this.geoLocationSuccess,this.geoLocationFailed);
		        } 
		        else 
		        {
		          alert("Pls turn on gps services");
		        }
			},

			geoLocationSuccess: function (position) {
				this.currentPos = {
	              lat: position.coords.latitude,
	              lng: position.coords.longitude
	            };

	            if(this.me) 
				{
			        this.me.setMap(null);
			        this.me = null;
				}

	            this.me = new google.maps.Marker({
				        position: this.currentPos,
				        //icon: 'http://localhost/images/test.png',
				        map: this.map,
				        animation: google.maps.Animation.DROP
				});

				this.map.panTo(this.currentPos);
				this.map.setZoom(16);
			},

			geoLocationFailed : function () {
				alert("browser doesn't support geo Location");
			},
			
			search : function() {

				var uri = this.$env.get('APP_URI') + 'api/search?';

				uri += 'useCircleDetector=' + this.searchOptions.useCircleDetector;
				uri += '&center=' + this.circleTool.center;
				uri += '&radius=' + this.circleTool.radius;
				var vm = this;

		        this.$http.get(uri).then((response) => 
				{	
					debugger;
					var originalClubs = response.data;
					this.clubs = originalClubs.filter(function($var){
						return  (google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng($var.lat, $var.lng), vm.circleTool.center)) <= vm.circleTool.radius;
					});

					this.clearPrevSearchResult();
					this.displayResult();
				}, (response) => {

				});	
			},

			clearPrevSearchResult : function () {
				for (var i = 0; i < this.clubMarkers.length; i++) {
		          this.clubMarkers[i].setMap(null);
		        }
		        this.clubMarkers = [];
			},

			displayResult : function () {
				for (var i = 0; i < this.clubs.length; i++) {
		            this.pinResults(this.clubs[i], i, 200);
				}

				if(this.clubs.length > 0) this.calculateZoom();
			},

			pinResults : function (club, key, timeout) {

				var vm = this;

				var position = {
	              lat: parseFloat(club.lat),
	              lng: parseFloat(club.lng),
	            };

		        var marker = new google.maps.Marker({
		            position: position,
		            map: this.map,
		            //icon: 'http://localhost/images/test.png',
		            animation: google.maps.Animation.DROP
		        });

		        /*marker.addListener('mouseover', this.markerHovered(marker));*/
		        marker.addListener('mouseover', function (){
		        	var point = vm.fromLatLngToPoint(marker.getPosition());
				    $('.search-tooltip').css({
				        'left': point.x,
				        'top': point.y
				    });

				    vm.$refs.tooltip.hover = true;
				    vm.$refs.tooltip.club = club;
		        });
		        marker.addListener('mouseout', this.markerOut);
		        this.clubMarkers.push(marker);	
			},

			markerOut : function () {
				this.$refs.tooltip.hover = false;
			},
			
			fromLatLngToPoint : function (latLng) {
			    var topRight = this.map.getProjection().fromLatLngToPoint(this.map.getBounds().getNorthEast());
			    var bottomLeft = this.map.getProjection().fromLatLngToPoint(this.map.getBounds().getSouthWest());
			    var scale = Math.pow(2, this.map.getZoom());
			    var worldPoint = this.map.getProjection().fromLatLngToPoint(latLng);
			    return new google.maps.Point((worldPoint.x - bottomLeft.x) * scale, (worldPoint.y - topRight.y) * scale);
			},

			calculateZoom : function () {
				this.bounds = this.createBoundsForMarkers();
				this.setCenter();
				this.setZoom();
			},

			setCenter : function () {
				this.map.panTo(this.bounds ? this.bounds.getCenter() : this.center);
			},

			setZoom : function () {
				this.map.setZoom(this.bounds ? this.getBoundsZoomLevel() : this.zoom);
			},

			getBoundsZoomLevel : function () {

			    var WORLD_DIM = { height: 256, width: 256 };
			    var ZOOM_MAX = 21;
			    var mapDim = {
				    height: $('#map').height(),
				    width: $('#map').width()
				}

			    function latRad(lat) {
			        var sin = Math.sin(lat * Math.PI / 180);
			        var radX2 = Math.log((1 + sin) / (1 - sin)) / 2;
			        return Math.max(Math.min(radX2, Math.PI), -Math.PI) / 2;
			    }

			    function zoom(mapPx, worldPx, fraction) {
			        return Math.floor(Math.log(mapPx / worldPx / fraction) / Math.LN2);
			    }

			    var ne = this.bounds.getNorthEast();
			    var sw = this.bounds.getSouthWest();

			    var latFraction = (latRad(ne.lat()) - latRad(sw.lat())) / Math.PI;
			    
			    var lngDiff = ne.lng() - sw.lng();
			    var lngFraction = ((lngDiff < 0) ? (lngDiff + 360) : lngDiff) / 360;
			    
			    var latZoom = zoom(mapDim.height, WORLD_DIM.height, latFraction);
			    var lngZoom = zoom(mapDim.width, WORLD_DIM.width, lngFraction);

			    return Math.min(latZoom, lngZoom, ZOOM_MAX) - 1;
			},

			createBoundsForMarkers : function () {
			    var bounds = new google.maps.LatLngBounds();
			    $.each(this.clubMarkers, function() {
			        bounds.extend(this.getPosition());
			    });

			    return bounds;
			},
		},

		components : {
			SearchTooltip,
		}
	}
</script>