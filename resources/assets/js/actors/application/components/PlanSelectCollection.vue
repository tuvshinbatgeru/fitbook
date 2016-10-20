<template>
	<div class="row small-up-1 medium-up-2 large-up-5" style="font-size:12px;">
		<div class="column">
		    <multiselect
		      :options="dateOption",
		      :selected="dateSelection",
		      placeholder="Date",
		      select-label='сонгох'
		      selected-label='сонгосон' 
		      deselect-label='устгах'
		      :searchable="false",
		      @update="dateUpdate"
		      label="label"
		      key="label"
		      id="date">
		    </multiselect>
	  	</div>
	  	<div class="column">
	  		<multiselect
		      :options="heartOption",
		      :selected="heartSelection",
		      placeholder="Heart",
		      select-label='сонгох'
		      selected-label='сонгосон' 
		      deselect-label='устгах'
		      @update="heartUpdate"
		      :searchable="false",
		      label="label"
		      key="label"
		      id="heart">
		    </multiselect>
	  	</div>
	  	<div class="column">
	  		<multiselect
		      :options="priceOption",
		      :selected="priceSelection",
		      placeholder="Price",
		      select-label='сонгох'
		      selected-label='сонгосон' 
		      deselect-label='устгах'
		      @update="priceUpdate"
		      :searchable="false",
		      label="label"
		      key="label"
		      id="price">
		    </multiselect>
	  	</div>
	  	<div class="column">
	  		<multiselect
		      :options="freqOption",
		      :selected="freqSelection",
		      @update="freqUpdate"
		      placeholder="Freq",
		      select-label='сонгох'
		      selected-label='сонгосон' 
		      deselect-label='устгах'
		      :searchable="false",
		      label="label"
		      key="label"
		      id="freq">
		    </multiselect>
	  	</div>
	  	<div class="column">
	  		<multiselect
		      :options="subsOption",
		      :selected="subsSelection",
		      @update="subsUpdate"
		      placeholder="Subs",
		      select-label='сонгох'
		      selected-label='сонгосон' 
		      deselect-label='устгах'
		      :searchable="false",
		      label="label"
		      key="label"
		      id="date">
		    </multiselect>
	  	</div>
	</div>
	<div class="row">
		<custom-search-tag v-for="filter in selectedFilters" :tag="filter">
		</custom-search-tag>
	</div>
</template>

<script>

	export default {
		data() {
		    return {
		        dateOption : {},
		        dateSelection : null,
		        heartOption : {},
		        heartSelection : null,
		        priceOption : {},
		        priceSelection : null,
		        freqOption : {},
		        freqSelection : null,
		        subsOption : {},
		        subsSelection : null,
		    }
	    },

	    ready : function () {
	    	this.subsOption = [];
		    this.subsOption.push({
		        "label" : "HIGH",
			    "order" : "desc",
			    "name" : "subscription"
		    });

		    this.subsOption.push({
		    	"label" : "LOW",
			    "order" : "asc",
			    "name" : "subscription"
		    });

		    this.dateOption = [];
		    this.dateOption.push({
		        "label" : "NEWEST",
			    "order" : "desc",
			    "name" : "date"
		    });

		    this.dateOption.push({
		    	"label" : "OLDEST",
			    "order" : "asc",
			    "name" : "date"
		    });

		    this.heartOption = [];
		    this.heartOption.push({
		    	"label" : "HIGH",
			    "order" : "desc",
			    "name" : "heart"
		    });

		    this.heartOption.push({
		    	"label" : "LOW",
			    "order" : "asc",
			    "name" : "heart"
		    });


		    this.priceOption = [];
		    this.priceOption.push({
		    	"label" : "HIGH",
			    "order" : "desc",
			    "name" : "price"
		    });

		    this.priceOption.push({
		    	"label" : "LOW",
			    "order" : "asc",
			    "name" : "price"
		    });

		    this.freqOption = [];
		    this.freqOption.push({
		    	"label" : "DAYLY",
		    	"order" : "dayly",
		    	"name" : "freq",
		    });

		    this.freqOption.push({
		    	"label" : "WEEKLY",
		    	"order" : "weekly",
		    	"name" : "freq",
		    });

		    this.freqOption.push({
		    	"label" : "MONTHLY",
		    	"order" : "monthly",
		    	"name" : "freq",
		    });

		    this.freqOption.push({
		    	"label" : "YEARLY",
		    	"order" : "yearly",
		    	"name" : "freq",
		    });
		},

		events : {
			'removeTag' : function(tag) {
				switch(tag.name) {
					case "date" :
						this.dateSelection = null
						break;
					case "price" :
						this.priceSelection = null
						break;
					case "heart" : 
						this.heartSelection = null
						break;
					case "freq" : 
						this.freqSelection = null
						break;
					case "subscription" :
						this.subsSelection = null
						break;
				}
			},
		},

		methods : {
			resetFilter : function () {
				this.dateSelection = null;
				this.priceSelection = null;
				this.heartSelection = null;
				this.freqSelection = null;
				this.subsSelection = null;
			},

			dateUpdate : function (value) {
				this.dateSelection = value;
			},

			heartUpdate : function (value) {
				this.heartSelection = value;
			},

			priceUpdate : function (value) {
				this.priceSelection = value;
			},

			freqUpdate : function (value) {
				this.freqSelection = value;
			},

			subsUpdate : function (value) {
				this.subsSelection = value;
			},
		},

		computed : {
			selectedFilters : function () {

				var filter = []

				if(this.dateSelection) {
					filter.push(this.dateSelection)
				}
				if(this.heartSelection) {
					filter.push(this.heartSelection)
				}
				if(this.priceSelection) {
					filter.push(this.priceSelection)
				}
				if(this.freqSelection) {
					filter.push(this.freqSelection)
				}

				if(this.subsSelection) {
					filter.push(this.subsSelection)
				}

				this.$emit('update', filter)
				return filter
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