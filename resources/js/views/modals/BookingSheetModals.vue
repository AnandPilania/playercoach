<template>
	<div class="row">
	 <div class="col-sm-12">
	 	<!-- View -->
		<div class="modal fade" id="addEditBookingModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      	<h4 class="modal-title font-weight-bold">{{ category }}</h4>
                      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       	 <span aria-hidden="true">&times;</span>
                      	</button>
                    </div>
                    <div class="modal-body">

                    	<form v-on:submit.prevent="action == 'add' ? addBooking() : updateBooking()">
                    	    
                       <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" v-model="booking.title" class="form-control" placeholder="Booking Title">
                        </div>
                  	    <div class="form-group">
                  	      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  	      <button type="submit" class="btn btn-success">{{ action }}</button>
                  	    </div>
                    	</form>
                    </div>
               </div>
            </div>
        </div>

        <div class="modal fade" id="addEditResourceModal">
          <div class="modal-dialog view-modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title font-weight-bold">Add new resource</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form v-on:submit.prevent="resourceAction == 'add' ? addResource() : updateResource()">
                         <div class="form-group">
                             <label for="permissions" class="col-form-lebel text-md-right">Booking Sheet</label>
                             <multiselect
                                 v-model="resource.resource_type" 
                                 :options="resource_types"
                                 :multiple="false" 
                                 :close-on-select="true" 
                                 :clear-on-select="false" 
                                 :preserve-search="true" 
                                 placeholder="'Pick Resource Type'" 
                                 label="title" 
                                 track-by="title" 
                                 :preselect-first="false"
                                 id="resource_type"></multiselect>
                         </div>
                            <div class="form-group">
                              <label for="title">Title</label>
                              <input type="text" v-model="resource.title" class="form-control" placeholder="Resource Title">
                            </div>
                        <div class="form-group">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">{{ resourceAction }}</button>
                        </div>
                    </form>
                  </div>
             </div>
          </div>
      </div>

      <div class="modal fade" id="resourceSettingsModal">
          <div class="modal-dialog view-modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title font-weight-bold">Update resource settings</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form v-on:submit.prevent="resourceAction == 'add' ? addResource() : updateResource()">
                         <div class="form-group">
                             <label for="permissions" class="col-form-lebel text-md-right">Booking Sheet</label>
                             <multiselect
                                 v-model="resource.resource_type" 
                                 :options="resource_types"
                                 :multiple="false" 
                                 :close-on-select="true" 
                                 :clear-on-select="false" 
                                 :preserve-search="true" 
                                 placeholder="'Pick Resource Type'" 
                                 label="title" 
                                 track-by="title" 
                                 :preselect-first="false"
                                 id="resource_type"></multiselect>
                         </div>
                            <div class="form-group">
                              <label for="title">Title</label>
                              <input type="text" v-model="resource.title" class="form-control" placeholder="Resource Title">
                            </div>
                        <div class="form-group">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">{{ resourceAction }}</button>
                        </div>
                    </form>
                  </div>
             </div>
          </div>
      </div>

        <div 
          class="settingModal" 
          :class="{activeSetting:booking.isActiveSettingModel}" 
          id="settingBookingSheetModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex">
                        <div class="text-left">
                          <a href="#" @click.prevent="closeSettingModal"><i class="fas fa-angle-left"></i> Back</a>
                        </div>
                        <div class="text-right"><a href="#">Open in new window <i class="fas fa-sign-out-alt"></i></a></div>
                    </div>
                    <div class="modal-body">
                      <div class="crud-btn-area mb-3 d-flex">
                         <p class="text-white"> Resources</p>
                         <a 
                          href="#" 
                          class="btn btn-success add-btn"
                          data-toggle="modal" 
                          data-target="#addEditResourceModal"
                          @click.prevent="showResourceCreateForm">Add new Resource</a>
                      </div>
                      <div class="table-responsive mt-3" v-if="booking.resources.length > 0">
                            <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th class="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(resource,index) in booking.resources" :key="index" :data-id="index+1">
                                      <td>{{ resource.title }}</td>
                                      <td>{{ resource.craeted_at }}</td>
                                      <td>{{ resource.updated_at }}</td>
                                      <td class="action">
                                          <a 
                                            href="#" 
                                            class="btn btn-info" 
                                            @click.prevent="viewResourceSettings(index)" 
                                            data-toggle="modal" 
                                            data-target="#resourceSettingsModal">Settings</a>
                                          <a 
                                            href="#" 
                                            class="btn btn-success" 
                                            @click.prevent="showEditResourceForm(index)" 
                                            data-toggle="modal" 
                                            data-target="#addEditResourceModal">Edit</a>
                                          <a 
                                            @click.prevent="removeResource(resource.id)" 
                                            class="btn btn-danger">Delete</a>
                                      </td>
                                  </tr>

                                </tbody>
                            </table>
                      </div>
                      <div v-if="booking.resources.length <= 0">
                        <p class="alert alert-danger">There is no Resource</p>
                      </div>
                      <div class="crud-btn-area mb-3 d-flex">
                         <p class="text-white"> Display Hours</p>
                      </div>
                      <form @submit.prevent="updateBooking">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="start">Start</label>
                            <datetime 
                              type="time" 
                              input-class="form-control"
                              v-model="booking.settings.business_hours.start"></datetime>
                          </div>
                          <div class="col-md-6">
                            <label for="end">End</label>
                            <datetime 
                              type="time" 
                              input-class="form-control" 
                              v-model="booking.settings.business_hours.end"></datetime>
                          </div>
                        </div>
                        <div class="crud-btn-area mb-3 d-flex align-items-center">
                           <p class="text-white"> Genarl Settings</p>
                           <a 
                            class="btn btn-link" 
                            data-toggle="collapse" 
                            href="#generalCollaps" 
                            role="button" 
                            aria-expanded="false" 
                            aria-controls="generalCollaps"
                            @click.prevent="!isGeneralSettingOpen">
                            {{ isGeneralSettingOpen ? 'open' : 'close' }} <i class="" :class="isGeneralSettingOpen ? 'fa-angle-up' : 'fa-angle-down'"></i>
                          </a>
                        </div>
                        <div class="collapse show" id="generalCollaps">
                          <div class="card card-body">
                            <div class="form-group inline-group row align-items-center">
                              <label class="col-md-6"> Allow non-members to book?</label>
                              <div class="col-md-6">
                                <div class="onoffswitch">
                                  <input 
                                    type="checkbox" 
                                    v-model="booking.settings.business_hours.allow_non_member" 
                                    id="allow_non_member" 
                                    class="onoffswitch-checkbox"> 
                                  <label for="allow_non_member" class="onoffswitch-label">
                                    <span class="onoffswitch-inner"></span> 
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="form-group inline-group row align-items-center">
                              <label class="col-md-6"> What is the length of 1 unit of booking?</label>
                              <div class="col-md-6">
                                <select id="" class="form-control" v-model="booking.settings.business_hours.booking_unit_length">
                                  <option value="one_hour">1 hour</option>
                                  <option value="half_hour">30 minutes</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group inline-group row align-items-center">
                              <label class="col-md-6"> What is the maximum number of units allowed back to back?</label>
                              <div class="col-md-6">
                                <input type="number" v-model="booking.settings.business_hours.max_units" class="form-control" min="1">
                              </div>
                            </div>
                            <div class="form-group inline-group row align-items-center">
                              <label class="col-md-6">Do you want to add rules for total number of bookings allowed per time period? </label>
                              <div class="col-md-6">
                                <div class="onoffswitch">
                                  <input 
                                    type="checkbox"
                                    v-model="booking.settings.business_hours.allow_per_period" 
                                    id="allow_booking_per_period" 
                                    class="onoffswitch-checkbox"> 
                                  <label 
                                    data-toggle="collapse" 
                                    data-target="#collapsePeriod" 
                                    role="button" 
                                    aria-expanded="false" 
                                    aria-controls="collapsePeriod"
                                    for="allow_booking_per_period" 
                                    class="onoffswitch-label">
                                    <span class="onoffswitch-inner"></span> 
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12 collapse" :class="{show: booking.settings.business_hours.allow_per_period}" id="collapsePeriod">
                                  <div class="card card-body">
                                    <div v-for="(rule, index) in booking.settings.business_hours.rules" :key="index" class="form-group row">
                                        <div class="form-group col-md-3">
                                          <label for="plan">Plan</label>
                                          <select id="plan" class="form-control" v-model="rule.plan">
                                            <option value="everyone">Everyone</option>
                                            <option value="adult">Adult</option>
                                            <option value="junior">Junior</option>
                                            <option value="senior">Senior</option>
                                          </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                          <label for="max_book">Maximum book</label>
                                          <select id="max_book" v-model="rule.max_book" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                          </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                          <label for="booking_per">Bookings per</label>
                                          <select id="booking_per" v-model="rule.booking_per" class="form-control">
                                            <option value="day">day</option>
                                            <option value="week">week</option>
                                            <option value="month">month</option>
                                            <option value="year">year</option>
                                          </select>
                                        </div>
                                        <div class="col-md-3 align-self-center">
                                            <button type="button" class="btn btn-danger" @click.prevent="removeRule(index)"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <div class="">
                                        <button type="button" class="btn btn-success" @click.prevent="addRule">Add Rule</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="crud-btn-area mb-3 d-flex align-items-center">
                           <p class="text-white"> Do you want to create special time slots ?
                              <button type="button" class="btn btn-link p-0" data-toggle="tooltip" data-placement="right" title="Prime-times, guest free times, priority booking times">
                                <i class="fas fa-info-circle"></i>
                              </button>
                           </p>
                           <div class="onoffswitch inline-group mr-3">
                            <input 
                              type="checkbox"
                              v-model="booking.settings.business_hours.special_times"
                              id="special_times" 
                              class="onoffswitch-checkbox"> 
                            <label 
                              data-toggle="collapse" 
                              data-target="#specialTimesCollaps" 
                              role="button" 
                              aria-expanded="false" 
                              aria-controls="specialTimesCollaps"
                              for="special_times" 
                              class="onoffswitch-label">
                              <span class="onoffswitch-inner"></span> 
                              <span class="onoffswitch-switch"></span>
                            </label>
                          </div>
                        </div>

                        <div class="collapse" :class="{show: booking.settings.business_hours.special_times}" id="specialTimesCollaps">
                          <div class="card card-body">
                            <div v-for="(value, days_of_week) in booking.settings.business_hours.days_of_weeks" :key="days_of_week">
                              <a 
                              class="btn btn-block btn-success day_collaps text-left" 
                              data-toggle="collapse" 
                              :href="'#'+days_of_week+'Collaps'" 
                              role="button" 
                              aria-expanded="false" 
                              :aria-controls="days_of_week+'Collaps'">{{ days_of_week }}</a>
                              <div class="collapse" :id="days_of_week+'Collaps'">
                                <div class="card card-body">
                                  <div v-for="(day, index) in booking.settings.business_hours.days_of_weeks[days_of_week]" :key="index" class="form-group row">
                                      <div class="col-md-5">
                                          <label for="start" class="cs-label">Start</label>
                                          <datetime
                                            :min-datetime="booking.settings.business_hours.start"
                                            :max-datetime="booking.settings.business_hours.end" 
                                            type="time" 
                                            input-class="form-control" 
                                            v-model="day.start"></datetime>
                                      </div>
                                      <div class="col-md-5">
                                          <label for="end" class="cs-label">End</label>
                                          <datetime 
                                            type="time"
                                            :min-datetime="booking.settings.business_hours.start"
                                            :max-datetime="booking.settings.business_hours.end" 
                                            input-class="form-control" 
                                            v-model="day.end"></datetime>
                                      </div>
                                      <div class="col-md-2 align-self-end">
                                          <button type="button" class="btn btn-danger" @click="removeSession(index, days_of_week)"><i class="fa fa-trash"></i></button>
                                      </div>
                                  </div>
                                  <div class="">
                                      <button type="button" class="btn btn-success" @click="addSession(days_of_week)">Add Session</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="crud-btn-area mb-3 d-flex align-items-center">
                           <p class="text-white"> Enable payment?
                              <button type="button" class="btn btn-link p-0" data-toggle="tooltip" data-placement="right" title="Prime-times, guest free times, priority booking times">
                                <i class="fas fa-info-circle"></i>
                              </button>
                           </p>
                           <div class="onoffswitch inline-group mr-3">
                            <input 
                              type="checkbox"
                              v-model="booking.settings.business_hours.enable_payment"
                              id="enable_payment" 
                              class="onoffswitch-checkbox"> 
                            <label 
                              data-toggle="collapse" 
                              data-target="#enablePaymentCollaps" 
                              role="button" 
                              aria-expanded="false" 
                              aria-controls="enablePaymentCollaps"
                              for="enable_payment" 
                              class="onoffswitch-label">
                              <span class="onoffswitch-inner"></span> 
                              <span class="onoffswitch-switch"></span>
                            </label>
                          </div>
                        </div>
                        <div class="collapse" :class="{show: booking.settings.business_hours.enable_payment}" id="enablePaymentCollaps">
                          <div class="card card-body">
                            <div class="form-group inline-group row align-items-center">
                              <label class="col-md-6">Enable payment for courts?</label>
                              <div class="col-md-6">
                                <div class="onoffswitch">
                                  <input 
                                    type="checkbox"
                                    v-model="booking.settings.business_hours.enable_courts_payment" 
                                    id="courts_payment" 
                                    class="onoffswitch-checkbox"> 
                                  <label 
                                    data-toggle="collapse" 
                                    data-target="#courtsPaymentCollaps" 
                                    role="button" 
                                    aria-expanded="false" 
                                    aria-controls="courtsPaymentCollaps"
                                    for="courts_payment" 
                                    class="onoffswitch-label">
                                    <span class="onoffswitch-inner"></span> 
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12 collapse" :class="{show: booking.settings.business_hours.enable_courts_payment}" id="courtsPaymentCollaps">
                                <div class="card card-body">
                                  <div class="table-responsive mt-3">
                                    <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                                        <thead>
                                             <tr>
                                                 <th>time / subscription</th>
                                                 <th>Adult Member</th>
                                                 <th>Junior Member</th>
                                                 <th>Senior Member</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                           <tr>
                                               <td>default prices</td>
                                               <td>$15</td>
                                               <td>$5</td>
                                               <td>$10</td>
                                           </tr>
                                           <tr>
                                               <td>Mondays 4-9 pm</td>
                                               <td>$23</td>
                                               <td>$15</td>
                                               <td>$18</td>
                                           </tr>

                                           <tr>
                                               <td>Tuesdays 8-10 am</td>
                                               <td>$18</td>
                                               <td>$13</td>
                                               <td>$15</td>
                                           </tr>

                                           <tr>
                                               <td>Wednesdays 12-4 pm</td>
                                               <td>$20</td>
                                               <td>$15</td>
                                               <td>$18</td>
                                           </tr>

                                           <tr>
                                               <td>Thursdays 3-9pm</td>
                                               <td>$23</td>
                                               <td>$0</td>
                                               <td></td>
                                           </tr>

                                           <tr>
                                               <td><a href="#"><i class="fas fa-plus"></i> add special time slot</a></td>
                                               <td></td>
                                               <td></td>
                                               <td></td>
                                           </tr>

                                         </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group inline-group row align-items-center">
                              <label class="col-md-6">Enable payment for advanced bookings?</label>
                              <div class="col-md-6">
                                <div class="onoffswitch">
                                  <input 
                                    type="checkbox"
                                    v-model="booking.settings.business_hours.enable_advanced_bookings_payment" 
                                    id="advanced_bookings_payment" 
                                    class="onoffswitch-checkbox"> 
                                  <label 
                                    data-toggle="collapse" 
                                    data-target="#advancedBookingsCollaps" 
                                    role="button" 
                                    aria-expanded="false" 
                                    aria-controls="advancedBookingsCollaps"
                                    for="advanced_bookings_payment" 
                                    class="onoffswitch-label">
                                    <span class="onoffswitch-inner"></span> 
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12 collapse" :class="{show: booking.settings.business_hours.enable_advanced_bookings_payment}" id="advancedBookingsCollaps">
                                  <div class="card card-body">
                                    <h3>Between 1 and 2 days before the booking</h3>
                                    <div class="table-responsive mt-3">
                                      <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                                          <thead>
                                               <tr>
                                                   <th></th>
                                                   <th>Adult Member</th>
                                                   <th>Junior Member</th>
                                                   <th>Senior Member</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                             <tr>
                                                 <td>default</td>
                                                 <td>2</td>
                                                 <td>1</td>
                                                 <td>1</td>
                                             </tr>
                                             <tr>
                                                 <td>time slot 1 </td>
                                                 <td>3</td>
                                                 <td>2</td>
                                                 <td></td>
                                             </tr>

                                             <tr>
                                                 <td>time slot 2</td>
                                                 <td>4</td>
                                                 <td>3</td>
                                                 <td></td>
                                             </tr>

                                             <tr>
                                                 <td>time slot 3</td>
                                                 <td>6</td>
                                                 <td>4</td>
                                                 <td></td>
                                             </tr>

                                             <tr>
                                                 <td><a href="#"><i class="fas fa-plus"></i> add special time slot</a></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                             </tr>

                                           </tbody>
                                      </table>
                                    </div>
                                    <h3>Between 2 and 5 days before the booking time</h3>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group text-right">
                          <button type="submit" class="btn btn-success">Update</button>
                        </div>
                      </form>
                        <div class="form-group">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
               </div>
            </div>
        </div>

	  </div>
	</div>
</template>
<script>

	export default {
		props: {
      booking: Object,
      resource_types: Array,
			action: String,
			category: String,
			addBooking: Function,
			updateBooking: Function,
      fetchBookings: Function,
      closeModal: Function,
		},
    data(){
      return {
        resource : {
          title: '',
          resource_type: '',
          booking_sheet_id: this.booking.id,
          business_hours: ''
        },
        resourceAction: 'add',
        isGeneralSettingOpen: true
      }
    },
    methods: {
      showResourceCreateForm: function(){
            this.resourceAction = "add"
            // this.category = "Create Resource Type"
            this.resource = {
              title: '',
              resource_type: '',
              booking_sheet_id: this.booking.id,
              business_hours: ''
            }
          },
      viewResourceType: function(index){
        this.resource = this.booking.resources[index]
      },
      showEditResourceForm: function(index){
        this.resourceAction = "edit"
        // this.category = "Edit Resource"
        this.resource = this.booking.resources[index]
      },
      viewResourceSettings: function(index) {
        this.resource = this.booking.resources[index]
      },
      addResource: function(){
        axios.post('/api/courtbooking/resource', this.resource).then(res => {
            if(res.data.success == true) {
              this.booking.resources = res.data.booking.resources
              // Flash success message
              toastr.success('Resource Added Successfully.')
              // this.$emit('fetchBookings')
              this.closeModal()
            }

            if(res.data.success == false) {
              this.errors = []
              for(let error of res.data.errors) {
                toastr.error(error)
                this.errors.push(error)
              }
            }
        })
        .catch(err => this.displayError(err.response));
      },
      updateResource: function(){
        axios.put(`/api/courtbooking/resource/${this.resource.id}`, this.resource)
        .then(res =>{
          if(res.data.success == true) {
            this.booking.resources = res.data.booking.resources
            // Flash success message
            toastr.success('Resource Updated Successfully')
            // this.$emit('fetchBookings')
            this.closeModal()
          }

          if(res.data.success == false) {
            this.errors = []
            for(let error of res.data.errors) {
              toastr.error(error)
              this.errors.push(error)
            }
          }

        })
        .catch(err => this.displayError(err.response));
      },
      removeResource: function(resource_id){
        let self = this;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this resource',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.value) {
                // this.$Progress.start()
                axios.delete(`/api/courtbooking/resource/${resource_id}`, {params: this.booking})
                .then(res => {
                    if( res.data.success == true ){
                        this.booking.resources = res.data.booking.resources
                        toastr.success("Resource Deleted Successfully")
                        self.fetchBookings()
                        // this.$Progress.finish()
                    }
                }).catch(err => {
                    // this.$Progress.start()
                    this.displayError(err.response)
                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        });
      },
      addRule: function(){
        let rules = [...this.booking.settings.business_hours.rules];
        rules.push({plan:'', max_book: '', booking_per: ''});
        this.booking.settings.business_hours.rules = rules;
      },
      removeRule: function(index){
        let rules = [...this.booking.settings.business_hours.rules];
        rules.splice(index, 1);
        this.booking.settings.business_hours.rules = rules;
      },
      addSession: function(day_of_weeks){
          let sessions = [...this.booking.settings.business_hours.days_of_weeks[day_of_weeks]];
          sessions.push({start:'',end: ''});
          this.booking.settings.business_hours.days_of_weeks[day_of_weeks] = sessions;
      },
      removeSession(index, day_of_weeks) {
          let sessions = [...this.booking.settings.business_hours.days_of_weeks[day_of_weeks]];
          sessions.splice(index, 1);
          this.booking.settings.business_hours.days_of_weeks[day_of_weeks] = sessions;
      },
      closeSettingModal: function(){
        Vue.delete(this.booking, 'isActiveSettingModel')
        this.booking.isActiveSettingModel = false
      }
    }
  }
</script>
<style scoped="scoped">
  #settingBookingSheetModal .modal-dialog {
    max-width: 80%;
    margin: 0px;
    margin-left: auto;
  }
  .add-btn{
    padding: 0px 15px;
    height: 40px;
    line-height: 40px;
    align-self: center;
    margin-right: 15px;
    background-color:#fff;
    border-color:#fff;
    color:#2a2a2a;
  }
  .inline-group .onoffswitch-switch {
    top: auto;
    bottom: auto;
  }
  .day_collaps {
    margin-bottom: 15px;
  }
</style>