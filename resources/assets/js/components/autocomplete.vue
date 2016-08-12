<template>
	<select id="tokenize" multiple="multiple" class="tokenize" style="width:100px;     margin: 0px;
    padding: 0px;
    border: 0px;
    display: none;">
	    <option value="1">Саун</option>
	    <option value="2">Душ</option>
	    <option value="3">Ёог</option>
	    <option value="4">Шүүгээ</option>
	    <option value="5">Eleanor</option>
	</select>
</template>

<script>
	export default {
		props: {
			hover : { default: false },
			club : {default: null},
		},
		
		data() {
			return {
				instance : null,
			}			
		},

		created : function () {
			
		},
		
		ready : function () {
			this.instance = $('.tokenize').tokenize({displayDropdownOnFocus:true});	
			this.instance.onDropdownShow = function (e) {
				alert('show');
			}
		},
	}
</script>
<style>
	div.TokenizeMeasure,
	div.Tokenize ul li span,
	div.Tokenize ul.TokensContainer li.TokenSearch input {
	    font-size: 50%;
	    font-weight: 600;
    	color: white !important;
	}

	div.Tokenize {
	    position: relative;
	    display: inline-block;
	    zoom: 1;
	}

	div.Tokenize ul {
	    list-style: none;
	    padding: 0;
	    margin: 0;
	}

	div.Tokenize ul li {
	    white-space: nowrap;
	}

	div.Tokenize ul.TokensContainer {
	    cursor: text;
	    padding: 0 5px 5px 0;
	    height: 100px;
	    overflow-y: auto;
	    background-color: white;
	    -webkit-touch-callout: none;
	    -webkit-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	}

	div.Tokenize ul.TokensContainer.Autosize {
	    height: auto;
	}

	div.Tokenize.Disabled ul.TokensContainer,
	div.Tokenize.Disabled ul.TokensContainer input {
	    cursor: not-allowed;
	}

	div.Tokenize ul.TokensContainer li.Token {
	    background-color: red;
	    padding: 0 5px;
	    line-height: 6px;
	    border-radius: 4px;
	}

	div.Tokenize ul.TokensContainer.ui-sortable:not(.ui-sortable-disabled) li.Token {
	    cursor: move;
	}

	div.Tokenize ul.TokensContainer li.Token.MovingShadow  {
	    border: 1px solid #fcefa1;
	    background-color: #fbf9ee;
	}

	div.Tokenize ul.TokensContainer li.Token.PendingDelete {
	    opacity : 0.5;
	    -moz-opacity : 0.5;
	    -ms-filter: "alpha(opacity=50)";
	    filter : alpha(opacity=50);
	}

	div.Tokenize ul.TokensContainer li.Token,
	div.Tokenize ul.TokensContainer li.TokenSearch {
	    margin: 1px 0 0 1px;
	    height: 12px;
	    float: left;
	}

	div.Tokenize ul.TokensContainer li.TokenSearch input {
	    margin: 0;
	    padding: 1px 0;
	    background-color: transparent;
	    line-height: 18px;
	    border: none;
	    outline: none;
	    font-weight: 100 !important;
	    color: #000 !important;
	}

	div.Tokenize ul.TokensContainer li.Placeholder {
	    color: #ddd;
	    position: absolute;
	    line-height: 20px;
	    padding: 5px 0 0 5px;
	    display: none;
	}

	div.Tokenize ul.TokensContainer,
	div.Tokenize ul.Dropdown {
	    border: 1px solid #ccc;
	}

	div.Tokenize ul.TokensContainer li.Token a.Close {
	    font-family: Arial, Helvetica, sans-serif !important;
	    font-size: 9px !important;
	    line-height: 10px;
	    float: right;
	    margin: 1px 0 0 5px;
	    padding: 0;
	    cursor: pointer;
	    color: #ebeced;
	}

	div.Tokenize.Disabled ul.TokensContainer li.Token a.Close {
	    display: none;
	}

	div.Tokenize ul.TokensContainer li.Token a.Close:hover {
	    background: transparent;
	    text-decoration: none;
	}

	div.Tokenize ul.Dropdown {
	    -webkit-box-sizing: border-box;
	    -moz-box-sizing: border-box;
	    -ms-box-sizing: border-box;
	    box-sizing: border-box;

	    display: none;
	    width: 100%;
	    padding: 5px 0;
	    margin: -1px 0 0 0;
	    position: absolute;
	    background-color: white;
	    overflow-y: auto;

	    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
	    -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
	    -o-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
	    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);

	    -webkit-background-clip: padding-box;
	    -moz-background-clip: padding;
	    background-clip: padding-box;

	    -webkit-border-radius: 0 0 6px 6px;
	    -moz-border-radius: 0 0 6px 6px;
	    border-radius: 0 0 6px 6px;

	    z-index: 20;
	}

	div.Tokenize ul.Dropdown li {
	    padding: 5px 20px;
	    overflow: hidden;
	    cursor: pointer;
	}

	div.Tokenize ul.Dropdown li.Hover {
	    color: white;
	    text-decoration: none;
	    background-color: #0081c2;
	    background-image: -moz-linear-gradient(top, #0088cc, #0077b3);
	    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0077b3));
	    background-image: -webkit-linear-gradient(top, #0088cc, #0077b3);
	    background-image: -o-linear-gradient(top, #0088cc, #0077b3);
	    background-image: linear-gradient(to bottom, #0088cc, #0077b3);
	    background-repeat: repeat-x;
	    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0077b3', GradientType=0);
	}
</style>