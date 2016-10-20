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
		        selectedFilters : [],
		    }
	    },

	    ready : function () {
	    	this.subsOption = [];
		    this.subsOption.push({
		        "label" : this.$t('subsHighLabel'),
			    "order" : "desc",
			    "name" : "subscription"
		    });

		    this.subsOption.push({
		    	"label" : this.$t('subsLowLabel'),
			    "order" : "asc",
			    "name" : "subscription"
		    });

		    this.dateOption = [];
		    this.dateOption.push({
		        "label" : this.$t('dateHighLabel'),
			    "order" : "desc",
			    "name" : "date"
		    });

		    this.dateOption.push({
		    	"label" : this.$t('dateLowLabel'),
			    "order" : "asc",
			    "name" : "date"
		    });

		    this.heartOption = [];
		    this.heartOption.push({
		    	"label" : this.$t('heartHighLabel'),
			    "order" : "desc",
			    "name" : "heart"
		    });

		    this.heartOption.push({
		    	"label" : this.$t('heartLowLabel'),
			    "order" : "asc",
			    "name" : "heart"
		    });


		    this.priceOption = [];
		    this.priceOption.push({
		    	"label" : this.$t('priceHighLabel'),
			    "order" : "desc",
			    "name" : "price"
		    });

		    this.priceOption.push({
		    	"label" : this.$t('priceLowLabel'),
			    "order" : "asc",
			    "name" : "price"
		    });

		    this.freqOption = [];
		    this.freqOption.push({
		    	"label" : this.$t('daylyLabel'),
		    	"order" : "dayly",
		    	"name" : "freq",
		    });

		    this.freqOption.push({
		    	"label" : this.$t('weeklyLabel'),
		    	"order" : "weekly",
		    	"name" : "freq",
		    });

		    this.freqOption.push({
		    	"label" : this.$t('monthlyLabel'),
		    	"order" : "monthly",
		    	"name" : "freq",
		    });

		    this.freqOption.push({
		    	"label" : this.$t('yearlyLabel'),
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

				this.filterUpdated();
			},
		},

		methods : {
			resetFilter : function () {
				this.dateSelection = null;
				this.priceSelection = null;
				this.heartSelection = null;
				this.freqSelection = null;
				this.subsSelection = null;
				this.filterUpdated();
			},

			setNewestFilterOn : function () {
				this.resetFilter();
				this.dateSelection = this.dateOption[0];
			},

			dateUpdate : function (value) {
				this.dateSelection = value;
				this.filterUpdated();
			},

			heartUpdate : function (value) {
				this.heartSelection = value;
				this.filterUpdated();
			},

			priceUpdate : function (value) {
				this.priceSelection = value;
				this.filterUpdated();
			},

			freqUpdate : function (value) {
				this.freqSelection = value;
				this.filterUpdated();
			},

			subsUpdate : function (value) {
				this.subsSelection = value;
				this.filterUpdated();
			},

			filterUpdated : function () {
				this.selectedFilters = []

				if(this.dateSelection) {
					this.selectedFilters.push(this.dateSelection)
				}
				if(this.heartSelection) {
					this.selectedFilters.push(this.heartSelection)
				}
				if(this.priceSelection) {
					this.selectedFilters.push(this.priceSelection)
				}
				if(this.freqSelection) {
					this.selectedFilters.push(this.freqSelection)
				}

				if(this.subsSelection) {
					this.selectedFilters.push(this.subsSelection)
				}

				this.$emit('update', this.selectedFilters)
			}
		},

		locales : {
			en : {
				dateHighLabel : 'Newest',
				dateLowLabel : 'Oldest',
				subsHighLabel : 'Popular',
				subsLowLabel : 'Least',
				heartHighLabel : 'Loved',
				heartLowLabel : 'Unloved',
				priceHighLabel : 'Expensive',
				priceLowLabel : 'Cheap',
				daylyLabel : 'Dayly',
				weeklyLabel : 'Weekly',
				monthlyLabel : 'Monthly',
				yearlyLabel : 'Yearly',
			},
			mn : {
				dateHighLabel : 'Шинэ',
				dateLowLabel : 'Хуучин',
				subsHighLabel : 'Алдартай',
				subsLowLabel : 'Least',
				heartHighLabel : 'Дуртай',
				heartLowLabel : 'Дургүй',
				priceHighLabel : 'Үнэтэй',
				priceLowLabel : 'Хямд',
				daylyLabel : 'Өдөр',
				weeklyLabel : 'Долоо хоног',
				monthlyLabel : 'Сар',
				yearlyLabel : 'Жил',
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