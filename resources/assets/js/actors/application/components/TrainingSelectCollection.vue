<template>
	<div class="row small-up-1 medium-up-2 large-up-5" style="font-size:12px;">
		<div class="column">
		    <multiselect 
              :options="clubGenres" 
              :selected="genre" 
              :multiple="false"
              :clear-on-select="false" 
              :close-on-select="true" 
              :searchable="false"
              select-label='сонгох'
              selected-label='сонгосон' 
              deselect-label='устгах'
              label="name"
              key="name"
              @update="updateGenres"
              :placeholder="$t('genre')">
                <span slot="noResult">{{$t('noresult')}}</span>
          </multiselect>
	  	</div>
	</div>
	<div class="row">
		<custom-search-tag 
			v-for="filter in selectedFilters" 
			:tag="filter"
			label="name">
		</custom-search-tag>
	</div>
</template>

<script>

	export default {
		props : {
			clubId : {}
		},

		data() {
		    return {
		        selectedFilters : [],
		        genre : null,
		        clubGenres : [],
		    }
	    },

	    created : function () {
	    	this.getGenres()
	    },

		events : {
			'removeTag' : function(tag) {
				this.genre = null
				this.filterUpdated()
			},
		},

		methods : {
	        getGenres : function () {
	            this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.clubId + '/capability').then(res => {
	                this.clubGenres = res.data.result
	            }).catch(err => {
	            });
	        },

			resetFilter : function () {
				this.genre = null;
				this.filterUpdated();
			},

			updateGenres : function (value) {
				this.genre = value;
				this.filterUpdated();
			},

			filterUpdated : function () {
				this.selectedFilters = []

				if(this.genre) {
					this.selectedFilters.push(this.this.genre)
				}

				this.$emit('update', this.selectedFilters)
			}
		},

		locales : {
			en : {

			},
			mn : {

			}
		}
	}
</script>

<style lang="scss">
	.multiselect__tag {
	    position: relative;
	    display: inline-block;
	    padding: 4px 26px 4px 10px;
	    border-radius: 5px;
	    margin-right: 10px;
	    color: #fff;
	    line-height: 1;
	    background: #41b883;
	    margin-bottom: 8px;
	    white-space: nowrap;
	}

	.multiselect__tag span {

	}

	.multiselect__tag-icon {
	    cursor: pointer;
	    margin-left: 7px;
	    position: absolute;
	    right: 0;
	    top: 0;
	    bottom: 0;
	    font-weight: 700;
	    font-style: initial;
	    width: 22px;
	    text-align: center;
	    line-height: 22px;
	    -webkit-transition: all .2s ease;
	    transition: all .2s ease;
	    border-radius: 5px;
	}
</style>