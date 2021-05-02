<style scoped>
.bethapa-table-header {
    font-weight: bold;
    color: #806104;
    font-size: 1.1em;
    border-bottom: 1px solid rgb(3, 46, 10);
    margin-bottom: 20px;
    width: 100%;
}
.bethapa-component-header {
      font-weight: bold;
    color: #343a40;
    font-size: 3.1em;
    border-bottom: 1px solid rgb(3, 46, 10);
    margin-bottom: 20px;
    width: 100%;
}
button.add-newm {
    display: inline-block;
    float: right;
    font-size: 0.6em;
    /* padding: 0px; */
    background: #E86325;
    font-weight: bold;
    /* border: 1px solid black; */
    box-shadow: 0px 0px 0.5px black;
}
.mysalessect {
    padding: 0rem;
    float: right;
}

</style>

<template>

    <div>
        <!-- the HGeaders -->
        <br>
        <div class="row">
          <div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Sales</h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- end of Headers -->

        <!-- Start of the -->
 <div class="bethapa-component-header" >Form Components </div>        
<div class="col-12 col-sm-12 col-lg-12">
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">MAIN MENU</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab"
                     data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">SUB-MENUS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" 
                    aria-controls="custom-tabs-two-messages" aria-selected="false">VUE-COMPONENTS</a>
                  </li>
                 
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-settings-tab" data-toggle="pill"
                     href="#custom-tabs-two-settings" role="tab" aria-controls="custom-tabs-two-settings" aria-selected="false">FORM / COMPONENT FEATURES</a>
                  </li>

                   <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-three-tab" data-toggle="pill" href="#custom-tabs-two-three" role="tab" aria-controls="custom-tabs-two-three" aria-selected="false">Employee Leaves</a>
                  </li>


                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-four-tab" data-toggle="pill" href="#custom-tabs-two-four" role="tab" aria-controls="custom-tabs-two-four" aria-selected="false">Four</a>
                  </li>


                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-five-tab" data-toggle="pill" href="#custom-tabs-two-five" role="tab" aria-controls="custom-tabs-two-four" aria-selected="false">Five</a>
                  </li>


                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-six-tab" data-toggle="pill" href="#custom-tabs-two-six" role="tab" aria-controls="custom-tabs-two-six" aria-selected="false">Six</a>
                  </li>


                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-seven-tab" data-toggle="pill" href="#custom-tabs-two-seven" role="tab" aria-controls="custom-tabs-two-seven" aria-selected="false">Seven</a>
                  </li>


                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-eight-tab" data-toggle="pill" href="#custom-tabs-two-eight" role="tab" aria-controls="custom-tabs-two-eight" aria-selected="false">Eight</a>
                  </li>



                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                  
                  <!-- tab one start -->
                  <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                 
                 <div class="bethapa-table-header">
                      MAIN MENUS <button type="button" class="add-newm"  data-toggle="modal" data-target="#addNewmainmenu" >Add New </button>
                     </div>
                      <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                   
                      <th > # </th>
                      <th > NAME </th>
                      <th > ICON </th>
                      <th > MENU ORDER </th>
                     <th >  </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      
                 
                  
                
                      
                         
                                 <td>bnbnb</td>
                                 <td>nmnmn</td>
                                <td>bnbnb</td>
                                 <td>nmnmn</td>
                                 <td></td>
               
                              
                               
                    </tr>
              
                    
                  </tbody>
                
                                   </table>
    
                   
                   
                    </div>

 <!-- tab one end -->


<!-- Modal add menu -->
<div class="modal fade" id="addNewmainmenu">
        <div class="modal-dialog modal-dialog-centered modal-xl">
        <div  class="modal-content">
            <div  class="modal-header">
                <h4  class="modal-title">Add New</h4> 
                <h4  class="modal-title" style="display: none;">Update Record</h4> 
                <button  type="button" data-dismiss="modal" aria-label="Close" class="close"><span  aria-hidden="true">×</span></button></div> 
                <form class="form-horizontal" @submit.prevent="editmode ? updatevuecomponent():createnewsvuecomponent()">
                    <div  class="modal-body">
                  <div class="form-grouparranged  row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Component Name</label>
                    <div class="col-sm-6">
                      <input v-model="form.featurename" type="text" name="featurename"
        class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('featurename') }">
      <has-error :form="form" field="featurename"></has-error>
                    </div>
                   
      
                  </div>
                 
                  <div class="form-grouparranged  row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">System Name </label>
                    <div class="col-sm-6">
                    <input v-model="form.sysname" type="text" name="sysname"
                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('sysname') }">
                    <has-error :form="form" field="sysname"></has-error>
                                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Disolay Order </label>
                    <div class="col-sm-6">
                    <input v-model="form.dorder" type="text" name="dorder"
                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('dorder') }">
                    <has-error :form="form" field="dorder"></has-error>
                                    </div>
                  </div>
                  
                  
                    <div class="grouparranged row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Description </label>
                    <div class="col-sm-6">
                    <textarea v-model="form.description" type="text" name="description"
        class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
      <has-error :form="form" field="description"></has-error>
      
                                    </div>
                  </div>
                 
                 </div>
                 
                  <div  class="modal-footer">
                    <button  type="submit" class="btn btn-primary btn-sm">Create</button> 
                      <button  type="submit" class="btn btn-success btn-sm" style="display: none;">Update</button>
                        <button  type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Close</button >
                        </div>
                 </form>
                       </div>
                          </div>
                </div>

      <!-- End of Modal for -->
<!--  -->
                  <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                     Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam. 
                  </div>


                  <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                     Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna. 
                  </div>




                  <div class="tab-pane fade" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                     Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis. 
                  </div>



                   <div class="tab-pane fade" id="custom-tabs-two-three" role="tabpanel" aria-labelledby="custom-tabs-two-three-tab">
                     Employees  is. 
                  </div>

                    <div class="tab-pane fade" id="custom-tabs-two-four" role="tabpanel" aria-labelledby="custom-tabs-two-four-tab">
                     four  is. 
                  </div>



                <div class="tab-pane fade" id="custom-tabs-two-five" role="tabpanel" aria-labelledby="custom-tabs-two-five-tab">
                     five  is. 
                  </div>




  <div class="tab-pane fade" id="custom-tabs-two-six" role="tabpanel" aria-labelledby="custom-tabs-two-six-tab">
                     six  is. 
                  </div>


                    <div class="tab-pane fade" id="custom-tabs-two-seven" role="tabpanel" aria-labelledby="custom-tabs-two-seven-tab">
                     seven  is. 
                  </div>

  <div class="tab-pane fade" id="custom-tabs-two-eight" role="tabpanel" aria-labelledby="custom-tabs-two-eight-tab">
                     Eight  is. 
                  </div>








                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>



<!-- All modals container  -->



               
<!-- No Modals Beyond -->












          

          <!-- end of the body -->
    </div>
</template>

<script>
    export default {
         data(){
          
        return {
            form: new Form({
                /// Main menu name
                mainmenuname:'',
                systename:'',
                iconclass:'',
                dorder:'',

            })
            }
         },

methods:{
    createMainmenu(){
        this.form.post('api/mainmenu');
    }

},



        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
