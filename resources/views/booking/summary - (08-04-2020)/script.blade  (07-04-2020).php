<style>
#time-range p 
{
    font-family:"Arial", sans-serif;
    font-size:14px;
    color:#333;
}
.ui-slider-horizontal 
{
    height: 8px;
    #background: #D7D7D7;
    border: 1px solid #BABABA;
    box-shadow: 0 1px 0 #FFF, 0 1px 0 #CFCFCF inset;
    clear: both;
    margin: 8px 0;
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    -ms-border-radius: 6px;
    -o-border-radius: 6px;
    border-radius: 6px;
}
.ui-slider 
{
	width:480px;
	margin-left:8px;
    position: relative;
    text-align: left;
}
.ui-slider-horizontal .ui-slider-range 
{
    top: -1px;
    height: 100%;
}
.ui-slider .ui-slider-range 
{
    position: absolute;
    z-index: 1;
    height: 8px;
    font-size: .7em;
    display: block;
    border: 1px solid #5BA8E1;
    box-shadow: 0 1px 0 #AAD6F6 inset;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    -khtml-border-radius: 6px;
    border-radius: 6px;
    #background: #81B8F3;
    #background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
    #background-size: 100%;
    #background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #A0D4F5), color-stop(100%, #81B8F3));
    #background-image: -webkit-linear-gradient(top, #A0D4F5, #81B8F3);
    #background-image: -moz-linear-gradient(top, #A0D4F5, #81B8F3);
    #background-image: -o-linear-gradient(top, #A0D4F5, #81B8F3);
    #background-image: linear-gradient(top, #A0D4F5, #81B8F3);
}
.ui-slider .ui-slider-handle 
{
    border-radius: 50%;
    background: #F9FBFA;
    background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
    background-size: 100%;
    background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #C7CED6), color-stop(100%, #F9FBFA));
    background-image: -webkit-linear-gradient(top, #C7CED6, #F9FBFA);
    background-image: -moz-linear-gradient(top, #C7CED6, #F9FBFA);
    background-image: -o-linear-gradient(top, #C7CED6, #F9FBFA);
    background-image: linear-gradient(top, #C7CED6, #F9FBFA);
    width: 26px;
    height: 26px;
    -webkit-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
    -moz-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
    box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
    -webkit-transition: box-shadow .3s;
    -moz-transition: box-shadow .3s;
    -o-transition: box-shadow .3s;
    transition: box-shadow .3s;
}
.ui-slider .ui-slider-handle 
{
    position: absolute;
    z-index: 2;
    width: 26px;
    height: 26px;
    cursor: default;
    border: none;
    cursor: pointer;
}
.ui-slider .ui-slider-handle:after 
{
    content:"";
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    top: 50%;
    margin-top: -4px;
    left: 50%;
    margin-left: -4px;
    background: #30A2D2;
    -webkit-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
    -moz-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 white;
    box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
}
.ui-slider-horizontal .ui-slider-handle 
{
    top: -0.7em;
    margin-left: -.6em;
}

.ui-slider-handle:focus 
{
    outline:none;
}

.ui-slider a:focus 
{
    outline:none;
}
.card.rounded-lg 
{
    border-radius: 1rem!important;
}

td
{
	background: rgba(255,255,255,1);
background: -moz-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(255,255,255,1)), color-stop(47%, rgba(246,246,246,1)), color-stop(100%, rgba(237,237,237,1)));
background: -webkit-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: -o-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: -ms-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed', GradientType=1 );
}
td.bg-dark{
	background: rgba(104,104,104,1);
background: -moz-linear-gradient(-45deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(104,104,104,1)), color-stop(100%, rgba(52,58,64,1)));
background: -webkit-linear-gradient(-45deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
background: -o-linear-gradient(-45deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
background: -ms-linear-gradient(-45deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
background: linear-gradient(135deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#686868', endColorstr='#343a40', GradientType=1 );
Copy text
}
.peak
{
	color: white;
	padding: 1px;
	border-radius: 100px;
	font-size:12p3	
	
	padding-top:5px;
	background-color: #ff283c;
	background: rgba(220,53,69,1);
background: -moz-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(220,53,69,1)), color-stop(100%, rgba(255,59,79,1)));
background: -webkit-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -o-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -ms-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: linear-gradient(to right, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dc3545', endColorstr='#ff3b4f', GradientType=1 );
}
.badge-danger{
	background: rgba(220,53,69,1);
background: -moz-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(220,53,69,1)), color-stop(100%, rgba(255,59,79,1)));
background: -webkit-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -o-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -ms-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: linear-gradient(to right, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dc3545', endColorstr='#ff3b4f', GradientType=1 );
}
.high
{
	color: #ffffff;
   background: rgba(220,53,69,1);
background: -moz-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(220,53,69,1)), color-stop(100%, rgba(255,59,79,1)));
background: -webkit-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -o-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -ms-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: linear-gradient(to right, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dc3545', endColorstr='#ff3b4f', GradientType=1 );
 
}


.moderate
{
	color: #ffffff;
    background: rgba(237,178,0,1);
    background: -moz-linear-gradient(left, rgba(237,178,0,1) 0%, rgba(232,175,88,1) 100%);
    background: -webkit-gradient(left top, right top, color-stop(0%, rgba(237,178,0,1)), color-stop(100%, rgba(232,175,88,1)));
    background: -webkit-linear-gradient(left, rgba(237,178,0,1) 0%, rgba(232,175,88,1) 100%);
    background: -o-linear-gradient(left, rgba(237,178,0,1) 0%, rgba(232,175,88,1) 100%);
    background: -ms-linear-gradient(left, rgba(237,178,0,1) 0%, rgba(232,175,88,1) 100%);
    background: linear-gradient(to right, rgb(242, 184, 5) 0%, #ffc107 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#edb200', endColorstr='#e8af58', GradientType=1 );
 
}

.low
{
	color: #ffffff;
    background: rgba(150,176,3,1);
    background: -moz-linear-gradient(left, rgba(150,176,3,1) 0%, rgba(40,167,69,1) 100%);
    background: -webkit-gradient(left top, right top, color-stop(0%, rgba(150,176,3,1)), color-stop(100%, rgba(40,167,69,1)));
    background: -webkit-linear-gradient(left, rgba(150,176,3,1) 0%, rgba(40,167,69,1) 100%);
    background: -o-linear-gradient(left, rgba(150,176,3,1) 0%, rgba(40,167,69,1) 100%);
    background: -ms-linear-gradient(left, rgba(150,176,3,1) 0%, rgba(40,167,69,1) 100%);
    background: linear-gradient(to right, rgb(150, 176, 0) 0%, rgba(40,167,69,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#96b003', endColorstr='#28a745', GradientType=1 );
 
}

.clock
{
	padding:0px;
	display: inline-flex;
}

.segment
{
	width:40px;
	font-size:10px;
	display:block;
	margin-top:10px;
}

.break
{
	height: 5px;
    width: 480px;
	margin-left: 10px;
    margin-top: -15px;
    z-index: 1;
}

</style>