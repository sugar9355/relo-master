    <div class="row mt-3 crew">

        <div class="col">
          <div class="card hvr-shadow w-100 h-100">
          <div class="card-header recomended bg-transparent"></div>            
            <div class="card-body pt-1">
              <div class="custom-control custom-radio">
                <input type="radio" class="crew custom-control-input" name="man" id="man1">
                <label class="custom-control-label mb-3 w-100 text-center" for="man1"><strong>One Hauler</strong><img src="worker.svg" alt="" height="35" width="30" class="position-relative mb-1"></label>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card hvr-shadow w-100 h-100">
            <div class="card-header recomended bg-transparent"></div>            
            <div class="card-body pt-1">
              <div class="custom-control custom-radio">
                <input type="radio" class="crew custom-control-input" onclick="update_crew(1)"  name="man" id="man1u" @if($booking->crew_count == 1) checked @endif>
                <label class="custom-control-label mb-3 w-100 text-center" for="man1u"><strong>One Hauler + You</strong><i class="fas fa-people-carry fa-2x hvr-icon" aria-hidden="true"></i></label>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card hvr-shadow w-100 h-100 shadow"> 
            <div class="card-header recomended py-0 px-3   text-center bg-warning mb-1 rounded d-block">Recomended</div>           
            <div class="card-body pt-1">              
              <div class="custom-control custom-radio">
                <input type="radio" class="crew custom-control-input" onclick="update_crew(2)" name="man" id="man2" @if($booking->crew_count == 2) checked @endif>
                <label class="custom-control-label mb-3 w-100 text-center" for="man2"><strong>Two Hauler</strong><i class="fas fa-people-carry fa-2x hvr-icon" aria-hidden="true"></i></label>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card hvr-shadow w-100 h-100">
            <div class="card-header py-0 px-3   text-center bg-warning mb-1 rounded d-block recomended">Recomended</div>
            <div class="card-body pt-1">
              <div class="custom-control custom-radio">
                <input type="radio" class="crew custom-control-input" onclick="update_crew(3)" name="man" id="man3"  @if($booking->crew_count == 3) checked @endif>
                <label class="custom-control-label mb-3 w-100 text-center" for="man3"><strong>Three Hauler</strong><img src="worker.svg" alt="" height="35" width="30" class="position-relative mb-3"> + <i class="fas fa-people-carry fa-2x hvr-icon" aria-hidden="true"></i></label>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card hvr-shadow w-100 h-100"> 
            <div class="card-header recomended bg-transparent"></div>           
            <div class="card-body pt-1">
              <div class="custom-control custom-radio">
                <input type="radio" class="crew custom-control-input" onclick="update_crew(4)" name="man" id="man4"  @if($booking->crew_count == 4) checked @endif>
                <label class="custom-control-label mb-3 w-100 text-center" for="man4"><strong>Four Hauler</strong><i class="fas fa-people-carry fa-2x hvr-icon" aria-hidden="true"></i> + <i class="fas fa-people-carry fa-2x hvr-icon" aria-hidden="true"></i></label>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card hvr-shadow w-100 h-100">
            <div class="card-header recomended bg-transparent"></div>            
            <div class="card-body pt-1">
              <div class="custom-control custom-radio">
                <input type="radio" class="crew custom-control-input" name="man" id="man5">
                <label class="custom-control-label mb-3 w-100 text-center" for="man5"><strong>Only Truck</strong><i class="fas fa-truck fa-2x hvr-icon" aria-hidden="true"></i></label>
              </div>
            </div>
          </div>
        </div>


      </div>