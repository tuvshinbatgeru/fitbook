<template>
	<div v-if="toolbar" class="toolbar-top">
        <span class="toolbar">
            <span class="bold" style="font-weight: bold; color: #66d9ef">B</span>
            <span class="underline" style="text-decoration: underline; color: #a6e22e">U</span>
            <span class="italic" style="font-style: italic; color: #f92672">I</span>
            <span class="strike" style="text-decoration: line-through; color: #e6db74">S</span>
        </span>
    </div>

	<div id="custom-editor"
         spellcheck="false" 
		 class="row taggable--field inputor" 
		 contentEditable="true">
	</div>
</template>

<script>

	export default {
		props : {
			toolbar : {
				type : Boolean,
				default : true,
			},

			html : {},
		},

		methods : {
            getHTML : function () {
                return $('#custom-editor').html();
            }
        }
	}
</script>

<style lang="scss">

#taggable img {
	height:10px;
	width:10px;
}

.inputor {
    height: 80px;
    font-size: 12px;
}

.taggable--field {
    overflow-x: scroll;
    width:70%;
	background-color: #F5F5F0;
    -webkit-box-shadow: 0px 3px 15px 2px #F5F5F0;
    -moz-box-shadow: 0px 3px 15px 2px #F5F5F0;
    box-shadow: 0px 3px 15px 2px #F5F5F0;
    padding: 10px;
    outline: none;
    border-bottom: 1px solid #dbdbdb;
}

.toolbar-top {
    text-align: center;
    margin-bottom: 10px;
    margin-top: 10px;
}

.toolbar {
    cursor: pointer;
    border-bottom-left-radius: 5px;
    border-top-left-radius: 5px;
    border-bottom-right-radius: 5px;
    border-top-right-radius: 5px;
    background-color: #333332;
    color: white;
    -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.42);
    -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.42);
    box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.42);
}

.toolbar span {
    padding: 5px;
    margin: 0px;
}

blockquote {
    display: block;
    padding-left: 20px;
    border-left: 6px solid #df0d32;
    margin-left: -15px;
    padding-left: 15px;
    font-style: italic;
    color: #555;
}

p .tagged {
	background-color : #aecaec;
}

.atwho-view {
    position:absolute;
    top: 0;
    left: 0;
    display: none;
    margin-top: 18px;
    background: white;
    color: black;
    border: 1px solid #DDD;
    border-radius: 3px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    min-width: 120px;
    z-index: 11110 !important;
}

.atwho-view .atwho-header {
    padding: 5px;
    margin: 5px;
    cursor: pointer;
    border-bottom: solid 1px #eaeff1;
    color: #6f8092;
    font-size: 11px;
    font-weight: bold;
}

.atwho-view .atwho-header .small {
    color: #6f8092;
    float: right;
    padding-top: 2px;
    margin-right: -5px;
    font-size: 12px;
    font-weight: normal;
}

.atwho-inserted {
    background: #e4eff6;
    color: #7092a9;
    border-radius: 4px;
    padding: 2px 5px;
}

.atwho-view .atwho-header:hover {
    cursor: default;
}

.atwho-view .cur {
    background: #3366FF;
    color: white;
}
.atwho-view .cur small {
    color: white;
}
.atwho-view strong {
    color: #3366FF;
}
.atwho-view .cur strong {
    color: white;
    font:bold;
}
.atwho-view ul {
    /* width: 100px; */
    list-style:none;
    padding:0;
    margin:auto;
    max-height: 200px;
    overflow-y: auto;
}
.atwho-view ul li {
    display: block;
    padding: 5px 10px;
    border-bottom: 1px solid #DDD;
    cursor: pointer;
    /* border-top: 1px solid #C8C8C8; */
}
.atwho-view small {
    font-size: smaller;
    color: #777;
    font-weight: normal;
}


</style>