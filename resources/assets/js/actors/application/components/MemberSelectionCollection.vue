<template>
	<div class="row small-up-1 medium-up-2 large-up-5" style="font-size:12px;">
		<div class="column">
		    <multiselect 
              :options="dates" 
              :selected="selectedDate" 
              :multiple="false"
              :searchable="false"
              select-label='сонгох'
              selected-label='сонгосон' 
              deselect-label='устгах'
              label="label"
              key="label"
              @update="updateDates"
              :placeholder="$t('date')">
                <span slot="noResult">{{$t('noresult')}}</span>
          </multiselect>
	  	</div>
	  	<div class="column">
		    <multiselect 
              :options="memberTypes" 
              :selected="selectedType" 
              :multiple="false"
              :searchable="false"
              select-label='сонгох'
              selected-label='сонгосон' 
              deselect-label='устгах'
              label="label"
              key="label"
              @update="updateTypes"
              :placeholder="$t('member')">
                <span slot="noResult">{{$t('noresult')}}</span>
          </multiselect>
	  	</div>
	</div>
	<div class="row">
		<custom-search-tag 
			v-for="filter in selectedFilters" 
			:tag="filter"
			label="label">
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
		        selectedType : null,
		        memberTypes : [],
		        selectedDate : null,
		        dates : [],
		    }
	    },

	    ready : function () {
	    	this.dates.push({
	    		'label' : this.$t('dateHighLabel'),
	    		'order' : "asc",
	    		'name' : 'date',
	    	})

	    	this.dates.push({
	    		'label' : this.$t('dateLowLabel'),
	    		'order' : "desc",
	    		'name' : 'date',
	    	})

	    	this.memberTypes.push({
	    		'label' : this.$t('teacherLabel'),
	    		'order' : "teacher",
	    		'name' : 'member',
	    	})

	    	this.memberTypes.push({
	    		'label' : this.$t('managerLabel'),
	    		'order' : "manager",
	    		'name' : 'member',
	    	})

	    	this.memberTypes.push({
	    		'label' : this.$t('receptionLabel'),
	    		'order' : "reception",
	    		'name' : 'member',
	    	})
	    },

		events : {
			'removeTag' : function(tag) {
				switch (tag.name) {
					case 'date' : 
						this.selectedDate = null
						break
					case 'member' : 
						this.selectedType = null
						break
					default : 
						break
				}

				this.filterUpdated()
			},
		},

		methods : {
			resetFilter : function () {
				this.selectedDate = null
				this.selectedType = null
				this.filterUpdated()
			},

			updateDates : function (value) {
				this.selectedDate = value
				this.filterUpdated()
			},

			updateTypes : function (value) {
				this.selectedType = value
				this.filterUpdated()
			},

			filterUpdated : function () {
				this.selectedFilters = []

				if(this.selectedDate) {
					this.selectedFilters.push(this.selectedDate)
				}

				if(this.selectedType) {
					this.selectedFilters.push(this.selectedType)
				}

				this.$emit('update', this.selectedFilters)
			}
		},

		locales : {
			en : {
				member : 'Member',
				date : 'Date',
				dateHighLabel : 'Oldest',
				dateLowLabel : 'Newest',
				teacherLabel : 'Teacher',
				managerLabel : 'Manager',
				receptionLabel : 'Reception',
			},
			mn : {
				member : 'Төрөл',
				date : 'Хугацаа',
				dateHighLabel : 'Хуучин',
				dateLowLabel : 'Шинэ',
				teacherLabel : 'Багш',
				managerLabel : 'Менежер',
				receptionLabel : 'Ресепшен',
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