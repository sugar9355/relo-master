$(document).ready(function () {
    hideAll();
});
let addedToList = [];
let answersArray = [];
let validationLength = -1;
let preset = false;
let showingDiv = [];
let lastId = [];




function addRanking(id)
{
	
	var ranking = $('#ranking').val();
	
	$.ajax({

		type: "POST",
		data: {"_token": $('meta[name="csrf-token"]').attr('content'),"ranking": ranking,"ajax": true},
		url: "add_to_cart/"+id,

		success: function(msg)
		{
			console.log(data);
		}
	});
	
}

function getPreset(me, createCheck = null, id) {
    $("#submitButtons").show();
    preset = true;

    $("#presetShow").show();
    $("#addAdditional").show();

    $(".myActive").removeClass('myActive');
    $(me).addClass('myActive');
    if (createCheck != null){
        $("#preSetHeading").html("Create Your Own");
        $("#cart").html("");
        $("#addMore").show();
        $("#addAdditional").hide();
        return;
    }
    axios.get('add_preset_cart/'+id).then(response => {
        let html = "";
        let cartItems = response.data.data;
        let cartItemKeys = Object.keys(cartItems);
        let nameArray = [];
        cartItemKeys.forEach((cartItemKey) =>{
            nameArray.push(cartItems[cartItemKey].name);
        });
        filterListByArray(nameArray);

        /*$("#preSetHeading").html(response.data.title);
        cartItemKeys.forEach((cartItemKey)=>{
            addedToList.push(cartItems[cartItemKey].name);
            html += `<div class="col-md-2">
                        <img src="${cartItems[cartItemKey].image}" class="img-fluid my-3 d-block mx-auto">
                        <h2 class="item-img">${cartItems[cartItemKey].name}</h2>
                        <div class="quantity-buttons">
                            <button type="button" id="sub_${cartItems[cartItemKey].id}" onclick="removeToCart(this,${cartItems[cartItemKey].id})" class="sub">-</button>
                            <input type="text" id="" readonly value="0" class="col-3">
                            <button type="button" id="add_${cartItems[cartItemKey].id}" onclick="addToCart(this,${cartItems[cartItemKey].id})" class="add">+</button>
                        </div>
                    </div>`
        });
        $("#cart").html(html);*/
    }).catch(error=>{
        console.log(error);
    });
}

function filterListByArray(myArray) {
    showingDiv = [];
    for (let i = 0; i < myArray.length; i++) {
        let val = myArray[i];
        let filter = val.toUpperCase();
        let div = $(".custom-image");
        if (val == "") {
            for (let i = 0; i < div.length; i++) {
                let targetDiv = $(div[i]);
                targetDiv.show();
            }
            return
        }
        for (let y = 0; y < div.length; y++) {
            let targetDiv = $(div[y]);
            let txtVal = targetDiv.find("a").data("name");
            targetDiv.hide();
            if (txtVal.toUpperCase() === filter) {
                showingDiv.push(targetDiv);
            }
        }
    }
    for (let i = 0; i < showingDiv.length; i++) {
        showingDiv[i].show();
    }
}

function filterList(me) {
    let val = $(me).val();
    let filter = val.toUpperCase();
    let div = $(".custom-image");
    if(val == "") {
        if (!preset) {
            for (let i = 0; i < div.length; i++) {
                let targetDiv = $(div[i]);
                targetDiv.show();
            }
        }else{
            for (let i = 0; i < div.length; i++) {
                let targetDiv = $(div[i]);
                targetDiv.hide();
            }
            for (let i = 0; i < showingDiv.length; i++) {
                showingDiv[i].show();
            }
        }
        return
    }
    for (let i = 0; i < div.length; i++) {
        let targetDiv = $(div[i]);
        let txtVal = targetDiv.find("a").data("name");
        targetDiv.hide();
        if (txtVal.toUpperCase().indexOf(filter) > -1) {
            targetDiv.show();
        }
    }
}
function showHideAddMore(){
    $("#addMore").show();
    $("#addAdditional").hide();
}
function addToCart(me, id)
{
    let inputSelector = $(me).parent().children('input');
    let currVal = parseInt(inputSelector.val());
    let check = true;
    if (currVal == 0)
	{
        check = false;
        if (validationLength !== answersArray.length){
            getQuestions(me, id);
            return;
        }
    }
    let optionsArray = {};
    let token = document.querySelector('input[name="_token"]');
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.value;
    let myTotal = parseInt($(".cartTotal").html());
    let quantity = 1;
    if (!check) {
        optionsArray.answersArray = answersArray;
        optionsArray.additional_info = $("#additional_info").val();
        optionsArray.pickup = $("#itemPickup").val();
        quantity = parseInt($("#qty").val());
        optionsArray.drop = $("#itemDrop").val();
    }
    $(".cartTotal").html(myTotal+quantity);
    inputSelector.val(currVal+quantity);

    let junkQty = $("#junk").val();

    if (junkQty == "" || junkQty === undefined)
	{
        junkQty = 0;
    }

    let postData = 
	{
        qty: quantity,
        options: optionsArray,
        junk: junkQty
    };

    axios.post("add_to_cart/"+id, postData).then((response)=>
	{
        answersArray = [];
        $("#questionModal").modal('hide');
        $("#questionBody").html("");
        console.log(response);
    }).catch((error)=>{
        console.log(error)
    });
}
function addToList(name, id, image) {
    let index = addedToList.indexOf(id);
    if (index > -1){
        return;
    }
    addedToList.push(id);
    let html = `<div class="col-md-2" id="item_${id}">
                    <img src="${image}" class="img-fluid my-3 d-block mx-auto">
                    <h2 class="item-img">${name}</h2>
                    <div class="quantity-buttons">
                        <button type="button" id="sub_${id}" onclick="removeToCart(this,${id})" class="sub" style="background-color: #aa0114;border: none;color: white;border-radius: 2px;">-</button>
                        <input type="text" id="" readonly value="0" class="col-3">
                        <button type="button" id="add_${id}" onclick="addToCart(this,${id})" class="add"style="background-color: #aa0114;border: none;color: white;border-radius: 2px;">+</button>
                    </div>
                </div>`;
    $("#cart").append(html);
}
function removeToCart(me, id) {
    let token = document.querySelector('input[name="_token"]');
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.value;

    let inputSelector = $(me).parent().children('input');
    let currVal = parseInt(inputSelector.val());
    if  (currVal > 0){
        inputSelector.val(currVal-1);
        axios.post("remove_to_cart/"+id, {
            qty: currVal-1,
        }).then(() => {
            let total = parseInt($(".cartTotal").html());
            $(".cartTotal").html(total-1);
        }).catch((error)=>{
            console.log(error)
        });
    }
}

function changeDialog (me){
    let id = $(me).val();
    getQuestions("", id, lastId);
}

function getLastVal (me){
    lastId = $(me).val();
}
function getQuestions(me, id, lastId = 0){
    let html = "";
    axios.get(`get_questions/${id}/${JSON.stringify(addedToList)}`)
        .then(response => 
		{
            $("#questionModal").modal();
            $("#questionBody").html("Please Wait!");
            let image = response.data.data.image;
            let questions = response.data.data.questions;
            let locations = response.data.data.locations;
            //let items = response.data.data.items;
            let item = response.data.data.item;
			let ranking = response.data.data.ranking;
            validationLength = questions.length;
            if (lastId !== 0){
                let itemHtml = `
                        <div class="col-md-2" id="item_${id}">
                            <img src="${image}" class="img-fluid my-3 d-block mx-auto">
                            <h2 class="item-img">${item.name}</h2>
                            <div class="quantity-buttons">
                                <button type="button" id="sub_${id}" onclick="removeToCart(this,${id})" class="sub" style="background-color: #aa0114;border: none;color: white;border-radius: 2px;">-</button>
                                <input type="text" id="" readonly value="0" class="col-3">
                                <button type="button" id="add_${id}" onclick="addToCart(this,${id})" class="add"style="background-color: #aa0114;border: none;color: white;border-radius: 2px;">+</button>
                            </div>
                        </div>`;
                $("#item_"+lastId).replaceWith(itemHtml);
            }
            html += `<div class="row"><div class="col-md-6"><label for="itemPickup"> Quantity </label><input placeholder="Quantity" class="form-control" min="1" type="number" id="qty" value="1"></div>`;
            html += `<div class="col-md-6"><label for="itemPickup"> Similar Items </label> <select onchange="changeDialog(this)" onfocus="getLastVal(this)" class="form-control" name="item-pickup">`;
            // items.forEach((item) => {
                // let selected = "";
                // if (item.id == id){
                    // selected = "selected";
                // }
                // html += `<option value="${item.id}" ${selected}>${item.name}</option>`;
            // });
            html += `</select></div></div>`;
            html += `<div><img src="${image}" class="img-fluid" alt=""></div><hr>`;
			
            questions.forEach(question => {
                html += `<div class="text-left"><h6>Q. ${question.title}?</h6><div class="clearfix"><ul class="list-inline">`;
                question.answers.forEach(answer =>{
                    html +=         `<li class="list-inline-item"><input type="radio" onclick="storeQuestionAnswer('${answer.title}', ${question.id})" value="${answer.id}" name="question_${question.id}">${answer.title}</li>`;
                });
                html +=        `</ul>
                                    </div>
                                </div>`;
            });
			
			html += '<hr><div class="text-left">';
			html += '<strong> &#9734; What needs to be disassembled/reassembled?</strong>';
			html += '<p> - Please specify the item and the level of complexity from 1-5, i.e "bed frame, level 2"</p>';
			html += '<strong>Ranking:</strong>';
			html += `<select id="ranking" name="ranking" class="form-control" onchange="addRanking(${id})">`;
			
			ranking.forEach((rank) => 
			{
                html += `<option value="${rank.ranking_id}">${rank.ranking_name}</option>`;
            });
			html += `</select>`;
			
			html += `</div>`;
			
			
            html += `<ul class="list-unstyled"><li> <u style="cursor: pointer" onclick="$('#junk').show()">Do You Want Junk Removal</u></li></ul>`;
            html += `<div class="row"><div class="col-md-12"><input placeholder="Quantity" class="form-control my-2" style="display: none;" min="0" type="number" id="junk" value="0"></div></div>`;
            html += `<ul class="list-unstyled"><li> <u style="cursor: pointer" onclick="$('#additional_info').show()">Add  Additional  Details</u></li></ul>`;
            html += `<div class="row"><div class="col-md-12"><input placeholder="Additional Info" style="display: none" class="form-control my-2" type="text" id="additional_info"></div></div>`;
			
            html += `<div class="row"><div class="col-md-12 text-left"> <label for="itemPickup"> Pickup Location: </label> <select style="margin: 10px 0 !important; width: 100%;" class="form-control" name="item-pickup" id="itemPickup">`;
            locations.forEach((location, index) => {
                let selected = "";
                if (index === 0){
                    selected = "selected";
                }
                html += `<option value="${location}" ${selected}>${location}</option>`;
            });
            html += `</select></div></div>`;
            html += `<div class="row"><div class="col-md-12 text-left"> <label for="itemDrop"> Drop Location </label> <select style="margin: 10px 0 !important; width: 100%;" class="form-control" name="item-pickup" id="itemDrop">`;
            locations.forEach((location,index) => {
                let selected = "";
                let lastIndex = locations.length-1;
                if (index === lastIndex){
                    selected = "selected";
                }
                html += `<option value="${location}" ${selected}>${location}</option>`;
            });
            html += `</select></div></div>`;
            html += `<button class="btn btn-info custom-btn" onclick="addToCart('#add_${id}', ${id})">Add</button>`;
            $("#questionBody").html(html);
        })
        .catch(error => {
            //alert("please select locations on map page");
            //window.location = "/";
        });
}
function storeQuestionAnswer(answerId, questionId){
    let needle = questionId+"_";
    let newAnswer = questionId+"_"+answerId;
    let matchValue = answersArray.filter(answer => answer.indexOf(needle) > -1);
    let matchIndex = answersArray.indexOf(matchValue[0]);
    if (matchIndex > -1){
        answersArray[matchIndex] = newAnswer;
        return;
    }
    answersArray.push(newAnswer);
}
