<style>
  #summary #locations .loc-edit{
    position: absolute;
    right: 0;
    top: 0;
  }
  #summary .custom-control{
    padding: 0;
  }

  .custom-control-input:checked~.custom-control-label::before{
    border-color: #fff;
    background-color: var(--info);
    top: .40rem;
    left: -1.35rem;
    display: block;
    width: .7rem;
    height: .7rem;
  }
  /*#summary .custom-control input[type='radio'] + label:after, #summary .custom-control input[type='radio'] + label:before{
    border-radius: 0;
    background-color: transparent;
    border-color: #333;
  }*/
  #summary .crew .custom-control input[type='radio'] + label:after{    
    top: 5rem;
    left: 5rem;
  }
 #summary .crew .custom-control input[type='radio'] + label:before{    
    top: 5.12rem;
    left: 5.12rem;
  }
  #summary .custom-control input[type='radio'] + label strong{
    margin-bottom: 9px;
    display: block;

  }
  .custom-radio .custom-control-input:checked~.custom-control-label::after{
    background-image: none;
    border: 1.5px solid #c6c6c6;
    border-radius: 50%;   
  }
 /*#summary .custom-control input[type='radio']:checked + label:after, #summary .custom-control input[type='radio']:checked + label:before{
    border-radius: 0;
    background-color: #333;
    border-color: #333;
  }*/
.custom-control input[type='radio'] + label{
  opacity: 1;
  background-color: transparent;
}
.custom-control input[type='radio']:checked+label{
  opacity: 1;
  outline: none;
}
   #summary #insurancebox .media{
    min-width: 190px;
   }
  #summary #insurancebox .media .btn{
    padding: 2px 5px !important;
    height: 50%;
  }
  #summary #insurancebox .media span{
  }
  #summary #insurancebox .media .btn:last-of-type{
    background-color: #d39e00!important;
  }
  #chart_div{
  width: 400px;
  height: auto;
  margin: auto;
}

.text-orange{
  color: var(--orange)  
}
.hvr-sweep-to-right{
	color:#ffffff;
}
.hvr-sweep-to-right:hover, .hvr-sweep-to-right:hover>*, .hvr-sweep-to-right:hover input[type='radio'] + label:before{
	color: #ffffff !important;
	border-color: #ffffff  !important;
}
.hvr-sweep-to-right:hover input[type='radio'] + label.text-dark{
 	color: #fff !important;
 }
.hvr-sweep-to-right:hover i{	
	color: var(--white);
}
.hvr-sweep-to-right:before{
	border-radius: 5px;
	background-color: var(--dark);
}
.hvr-sweep-to-right:visited{
	background-color: #333;
}

#summary #inventory .media{
  margin-bottom: 10px;
  border-bottom: 1px solid #eee;
}
#summary #inventory .media a{
  width: 100px;
}
#summary #inventory .media .img-fluid{
  width: auto;
  height: auto;
  max-height: 90px;
  min-width: 70%;
  margin: 5px 0px;
}

 #summary .progress{
  overflow: unset;
  position: relative;
 }
 #summary .pricing{
    position: absolute;
    bottom: -45px;
    font-weight: bold;
    background-color: #ffffff;
    text-align: center;
    padding: 5px 10px;
    display: inline-block;
    border-radius: 5px;
    border: 1px solid #ddd;
    box-shadow: 0px 6px 16px #ddd;
 }
 span.pricing:before {
    content: '';
    left: 45%;
    border-right: 10px solid #3330;
    border-bottom: 20px solid #959595;
    border-top: 10px solid #45393900;
    border-left: 10px solid #95959500;
    height: 0;
    width: 0;
    display: block;
    position: absolute;
    top: -31px;
}

.recomended{
    width: 100%;
    border: none;
}

/*.loc-points .col:after{
  content: '\f30b';
  font-family: "Font Awesome 5 Pro";
  font-weight: 900;
  position: absolute;
  left: 0;
}*/
.loc-points .col{

}

</style>
