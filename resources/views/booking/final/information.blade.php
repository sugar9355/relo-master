<div class="col-md-7 mt-1  card">
    <!--<nav>-->
    <!--    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="display: flex;align-items: center;justify-content: space-around;padding-left:10px;padding-right: 10px">-->
    <!--        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Payment Information</a>-->
    <!--        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Personal Information</a>-->
    <!--    </div>-->
    <!--</nav>-->
    <div class="tab-content pt-3" id="nav-tabContent">
        <div class="tab-pane fade show active " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <h5 class="border-bottom pb-2 mt-3 "><h2 class="text-center card-header">Card Info</h2></h5>
            <div class="form-row mt-2">
                <div class="form-group col-md-4">
                    <!--<label for="">First Name on Card</label>-->
                    <!--<input type="text" class="form-control" name="pay_first_name">-->
                    <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="pay_first_name" type="text">
  <span>First Name on Card</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">Last Name on Card</label>-->
                    <!--<input type="text" class="form-control" name="pay_last_name">-->
                    <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="pay_last_name" type="text">
  <span>Last Name on Card</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label class="pure-material-textfield-outlined" for="">Card Number*</label>-->
                    <!--<input type="text" class="form-control" name="pay_card_num">-->
                     <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="pay_card_num" type="number" required>
  <span>Card Number*</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">Expiration Month</label>-->
                    <!--<select class="form-control" name="pay_expire_mon" id="pay_expire_mon">-->
                    <!--    <option value="01">Jan</option>-->
                    <!--    <option value="02">Feb</option>-->
                    <!--    <option value="03">Mar</option>-->
                    <!--    <option value="04">Apr</option>-->
                    <!--    <option value="05">May</option>-->
                    <!--    <option value="06">Jun</option>-->
                    <!--    <option value="07">Jul</option>-->
                    <!--    <option value="08">Aug</option>-->  
                    <!--    <option value="09">Sep</option>-->
                    <!--    <option value="10">Oct</option>-->
                    <!--    <option value="11">Nov</option>-->
                    <!--    <option value="12">Dec</option>-->
                    <!--</select>-->
                    <label id="img_category_label" class="field mr-3" for="img_category" data-value="">
            <span>Expiration Month</span>
            <div id="img_category"class="psuedo_select" name="img_category">
                  <span class="selected"></span>
                  <ul name="month" id="img_category_options"class="options">
                        <li class="option " id="ja" data-value="opt_1">January</li>
                        <li class="option" data-value="opt_1">February</li>
                        <li class="option" data-value="opt_1">March</li>
                        <li class="option" data-value="opt_1">April</li> 
                        <li class="option" data-value="opt_1">May</li>
                        <li class="option" data-value="opt_1">June</li>
                        <li class="option" data-value="opt_1">July</li>
                        <li class="option" data-value="opt_1">August</li>
                        <li class="option" data-value="opt_1">September</li>
                        <li class="option" data-value="opt_1">October</li>
                        <li class="option" data-value="opt_1">November</li>
                        <li class="option" data-value="opt_1">December</li>
                        
                  </ul>
            </div>
      </label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">Expiration Year</label>-->
                    <!--<select class="form-control" name="pay_expire_year" id="pay_expire_year">-->
                    <!--    <option value="2014">2014</option>-->
                    <!--    <option value="2015">2015</option>-->
                    <!--    <option value="2016">2016</option>-->
                    <!--    <option value="2017">2017</option>-->
                    <!--    <option value="2018">2018</option>-->
                    <!--    <option value="2019">2019</option>-->
                    <!--    <option value="2020">2020</option>-->
                    <!--</select>-->
                    <label id="img_category_label" class="field" for="img_category" data-value="">
            <span>Expiration Year</span>
            <div id="img_category"class="psuedo_select" name="img_category">
                  <span class="selected"></span>
                  <ul name="month" id="img_category_options"class="options">
                   
                        <li class="option" data-value="opt_1">2014</li>
                        <li class="option" data-value="opt_1">2015</li>
                        <li class="option" data-value="opt_1">2016</li> 
                        <li class="option" data-value="opt_1">2017</li>
                        <li class="option" data-value="opt_1">2018</li>
                        <li class="option" data-value="opt_1">2019</li>
                        <li class="option" data-value="opt_1">2020</li>
                    
                        
                  </ul>
            </div>
      </label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">CVV</label>-->
                    <!--<input type="text" class="form-control" name="pay_cvv">-->
                    <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="pay_cvv" type="number">
  <span>CVV</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">Phone Number*</label>-->
                    <!--<input type="text" class="form-control" name="pay_phone_num">-->
                      <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="pay_phone_num" type="tel" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
  <span>Phone Number* (ex: 333-333-3333)</span>
</label>
                </div>
            </div>
        </div>

    </div>
            <div class="tab-pane fade show " >
            <h5 class="border-bottom pb-2 mt-4 text-center"><h2 class="card-header text-center">Personal Information</h2>  
            </h5>
            <div class="form-row mt-2">
                <div class="form-group col-md-4">
                    <!--<label for="">First Name*</label>-->
                    <!--<input type="text" class="form-control" name="per_first_name">-->
                    <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="per_first_name" type="text" required>
  <span>First Name*</span>
</label>
                    
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">Last Name*</label>-->
                    <!--<input type="text" class="form-control" name="per_last_name">-->
                    <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="per_last_name" type="text" required>
  <span>Last Name*</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">Phone Number*</label>-->
                    <!--<input type="text" class="form-control" name="per_phone_num">-->
                    <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="per_phone_num" type="tel" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
  <span>Phone Number* (ex: 333-333-3333)</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">Email*</label>-->
                    <!--<input type="text" class="form-control" name="per_email">-->
                    <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="per_email" type="email" required>
  <span>Email*</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">Street Address*</label>-->
                    <!--<input type="text" class="form-control" name="per_str_addy">-->
                    <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="per_str_addy" type="text" required>
  <span>Street Address*</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">Apt, suit, etc</label>-->
                    <!--<input type="text" class="form-control" name="per_apt_num">-->
                    <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="per_apt_num" type="text">
  <span>Apt, suit, etc</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">City*</label>-->
                    <!--<input type="text" class="form-control" name="per_city">-->
                      <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="per_city" type="text" required>
  <span>City*</span>
</label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">State*</label>-->
                    <!--<select class="form-control" name="per_state" id="per_state">-->
                    <!--    <option value="AL">Alabama</option>-->
                    <!--    <option value="AK">Alaska</option>-->
                    <!--    <option value="AZ">Arizona</option>-->
                    <!--    <option value="AR">Arkansas</option>-->
                    <!--    <option value="CA">California</option>-->
                    <!--    <option value="CO">Colorado</option>-->
                    <!--    <option value="CT">Connecticut</option>-->
                    <!--    <option value="DE">Delaware</option>-->
                    <!--    <option value="DC">District Of Columbia</option>-->
                    <!--    <option value="FL">Florida</option>-->
                    <!--    <option value="GA">Georgia</option>-->
                    <!--    <option value="HI">Hawaii</option>-->
                    <!--    <option value="ID">Idaho</option>-->
                    <!--    <option value="IL">Illinois</option>-->
                    <!--    <option value="IN">Indiana</option>-->
                    <!--    <option value="IA">Iowa</option>-->
                    <!--    <option value="KS">Kansas</option>-->
                    <!--    <option value="KY">Kentucky</option>-->
                    <!--    <option value="LA">Louisiana</option>-->
                    <!--    <option value="ME">Maine</option>-->
                    <!--    <option value="MD">Maryland</option>-->
                    <!--    <option value="MA">Massachusetts</option>-->
                    <!--    <option value="MI">Michigan</option>-->
                    <!--    <option value="MN">Minnesota</option>-->
                    <!--    <option value="MS">Mississippi</option>-->
                    <!--    <option value="MO">Missouri</option>-->
                    <!--    <option value="MT">Montana</option>-->
                    <!--    <option value="NE">Nebraska</option>-->
                    <!--    <option value="NV">Nevada</option>-->
                    <!--    <option value="NH">New Hampshire</option>-->
                    <!--    <option value="NJ">New Jersey</option>-->
                    <!--    <option value="NM">New Mexico</option>-->
                    <!--    <option value="NY">New York</option>-->
                    <!--    <option value="NC">North Carolina</option>-->
                    <!--    <option value="ND">North Dakota</option>-->
                    <!--    <option value="OH">Ohio</option>-->
                    <!--    <option value="OK">Oklahoma</option>-->
                    <!--    <option value="OR">Oregon</option>-->
                    <!--    <option value="PA">Pennsylvania</option>-->
                    <!--    <option value="RI">Rhode Island</option>-->
                    <!--    <option value="SC">South Carolina</option>-->
                    <!--    <option value="SD">South Dakota</option>-->
                    <!--    <option value="TN">Tennessee</option>-->
                    <!--    <option value="TX">Texas</option>-->
                    <!--    <option value="UT">Utah</option>-->
                    <!--    <option value="VT">Vermont</option>-->
                    <!--    <option value="VA">Virginia</option>-->
                    <!--    <option value="WA">Washington</option>-->
                    <!--    <option value="WV">West Virginia</option>-->
                    <!--    <option value="WI">Wisconsin</option>-->
                    <!--    <option value="WY">Wyoming</option>-->
                    <!--</select>				-->
                    <label id="img_category_label" class="field" for="img_category" data-value="">
            <span>State</span>
            <div id="img_category"class="psuedo_select" name="img_category">
                  <span class="selected"></span>
                  <ul name="month" id="img_category_options"class="options">
                   
                        <li class="option state" data-value="AL">Alabama</li>
                        <li class="option state" data-value="AK">Alaska</li>
                        <li class="option state" data-value="AZ">Arizona</li> 
                        <li class="option state" data-value="AR">Arkansas</li>
                        <li class="option state" data-value="CA">California</li>
                        <li class="option state" data-value="CO">Colorado</li>
                        <li class="option state" data-value="CT">Connecticut</li>
                        <li class="option state" data-value="DE">Delaware</li>
                        <li class="option state" data-value="FL">Florida</li>
                        <li class="option state" data-value="GA">Georgia</li>
                        <li class="option state" data-value="HI">Hawaii</li>
                        <li class="option state" data-value="ID">Idaho</li>
                        <li class="option state" data-value="IL">Illinois</li>
                        <li class="option state" data-value="IN">Indiana</li>
                        <li class="option state" data-value="IA">Iowa</li>
                        <li class="option state" data-value="KS">Kansas</li>
                        <li class="option state" data-value="KY">Kentucky</li>
                        <li class="option state" data-value="LA">Louisiana</li>
                        <li class="option state" data-value="ME">Maine</li>
                        <li class="option state" data-value="MD">Maryland</li>
                        <li class="option state" data-value="MA">Massachusetts</li>
                        <li class="option state" data-value="MI">Michigan</li>
                        <li class="option state" data-value="MN">Minnesota</li>
                        <li class="option state" data-value="MS">Mississippi</li>
                        <li class="option state" data-value="MO">Missouri</li>
                        <li class="option state" data-value="MT">Montana</li>
                        <li class="option state" data-value="NE">Nebraska</li>
                        <li class="option state" data-value="NV">Nevada</li>
                        <li class="option state" data-value="NH">New Hampshire</li>
                        <li class="option state" data-value="NJ">New Jersey</li>
                        <li class="option state" data-value="NM">New Mexico</li>
                        <li class="option state" data-value="NY">New York</li>
                        <li class="option state" data-value="NC">North Carolina</li>
                        <li class="option state" data-value="ND">North Dakota</li>
                        <li class="option state" data-value="OH">Ohio</li>
                        <li class="option state" data-value="OK">Oklahoma</li>
                        <li class="option state" data-value="OR">Oregon</li>
                        <li class="option state" data-value="PA">Pennsylvania</li>
                        <li class="option state" data-value="RI">Rhode Island</li>
                        <li class="option state" data-value="SC">South Carolina</li>
                        <li class="option state" data-value="SD">South Dakota</li>
                        <li class="option state" data-value="TN">Tennessee</li>
                        <li class="option state" data-value="TX">Texas</li>
                        <li class="option state" data-value="UT">Utah</li>
                        <li class="option state" data-value="VT">Vermont</li>
                        <li class="option state" data-value="VA">Virginia</li>
                        <li class="option state" data-value="WA">Washington</li>
                        <li class="option state" data-value="WV">West Virginia</li>
                        <li class="option state" data-value="WI">Wisconsin</li>
                        <li class="option state" data-value="WY">Wyoming</li>
                    
                        <input type="hidden" name="per_state" id="per_state" />
                  </ul>
            </div>
      </label>
                </div>
                <div class="form-group col-md-4">
                    <!--<label for="">ZIP Code*</label>-->
                    <!--<input type="text" class="form-control" name="per_zip_code">-->
                     <label class="pure-material-textfield-outlined">
  <input placeholder=" " name="per_zip_code" required type="text" maxlength="5">
  <span>ZIP Code*</span>
</label>
                </div>
            </div>
        </div>
</div>
