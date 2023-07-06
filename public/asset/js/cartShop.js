let addedToList = [];
let answersArray = [];
let validationLength = -1;
function getPreset(me, createCheck = null, id) {
    hideAll();
    $("#submitButtons").show();
    $('#selectItem').select2({
        theme: "bootstrap",
        width: "100%",
    });

    $("#presetShow").show();
    $("#addAdditional").show();

    $(".custom-active").removeClass('custom-active');
    $(me).children().children().addClass('custom-active');
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
        $("#preSetHeading").html(response.data.title);
        cartItemKeys.forEach((cartItemKey)=>{
            addedToList.push(cartItems[cartItemKey].name);
            html += `<div class="input-group col-md-4 offset-md-4 bedroom-field">
                                <i class="btn border iconcolor fa fa-list user-fix">
                                </i>
                                <h2 class="item-img">${cartItems[cartItemKey].name}</h2>
                                <div class="quantity-buttons">
                                    <button type="button" id="sub_${cartItems[cartItemKey].id}" class="sub" onclick="removeToCart(this,${cartItems[cartItemKey].id})">-</button>
                                    <input type="text" id="" value="0" readonly class="field col-1">
                                    <button type="button" id="add_${cartItems[cartItemKey].id}" class="add" onclick="addToCart(this,${cartItems[cartItemKey].id})">+</button>
                                </div>
                            </div>`;
        });
        $("#cart").html(html);
    }).catch(error=>{
        console.log(error);
    });
}
function showHideAddMore(){
    $("#addMore").show();
    $("#addAdditional").hide();
}
function addToCart(me, id){
    getQuestions(me, id);
    if (validationLength !== answersArray.length){
        return;
    }
    let token = document.querySelector('input[name="_token"]');
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.value;

    let inputSelector = $(me).parent().children('input');
    let currVal = parseInt(inputSelector.val());
    let total = parseInt($(".cartTotal").html());
    $(".cartTotal").html(total+1);
    inputSelector.val(currVal+1);
    axios.post("add_to_cart/"+id, {
        qty: currVal+1,
        options: answersArray
    }).then((response)=>{
        answersArray = [];
        $("#questionModal").modal('hide');
        console.log(response);
    }).catch((error)=>{
        console.log(error)
    });
}
function addToList(me) {
    let id = $(me).val();
    let name = $('option:selected',me).text();
    let index = addedToList.indexOf(name);
    if (index > -1){
        $(me).val("");
        return;
    }
    addedToList.push(name);
    let html = `<div class="input-group col-md-4 offset-md-4 bedroom-field">
                                <i class="btn border iconcolor fa fa-list user-fix">
                                </i>
                                <h2 class="item-img">${name}</h2>
                                <div class="quantity-buttons">
                                    <button type="button" id="sub_${id}" class="sub" onclick="removeToCart(this,${id})">-</button>
                                    <input type="text" id="" value="0" readonly class="field col-1">
                                    <button type="button" id="add_${id}" class="add" onclick="addToCart(this,${id})">+</button>
                                </div>
                            </div>`;
    $(me).val("");
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
function getQuestions(me, id){
    let html = "";
    axios.get("get_questions/"+id)
        .then(response => {
            $("#questionModal").modal();
            $("#questionBody").html("Please Wait!");
            let questions = response.data.data;
            validationLength = questions.length;
            questions.forEach(question => {
                html += `<div>
                                    <h1>${question.title}</h1>
                                    <div>
                                        <ul>`;
                question.answers.forEach(answer =>{
                    html +=         `<li><input type="radio" onclick="storeQuestionAnswer('${answer.title}', ${question.id})" value="${answer.id}" name="question_${question.id}">${answer.title}</li>`;
                });
                html +=        `</ul>
                                    </div>
                                </div>`;
            });
            html += `<button class="btn btn-danger" onclick="addToCart('#add_${id}', ${id})">Add To Cart</button>`;
            $("#questionBody").html(html);
        })
        .catch(error => {
            console.log(error);
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
