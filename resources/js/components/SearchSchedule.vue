<template>
    <div class="col-xl-9 col-lg-9"  >

            <div class="row">

                <div id="mainDiv" class="col-md-12">

                    <div class="row">
                        <div style="margin-top:15px;" class="col-md-1">
                            <i @click="fetchPrevious" style="cursor: pointer" class="fa fa-angle-left fa-2x"></i>
                        </div>
                        <div  class="col-md-10 table-responsive ">
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th class="text-center" v-for="date in dates">{{getDate(date.Date)[0]}}<br><strong >{{getDate(date.Date)[1]}}   {{getDate(date.Date)[2]}}</strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="index in this.maxTimes" :key="index">
                                    <td class="text-center"><span class="timeClass" @click="instantRequest(dates[0],index-1)"  style="cursor: pointer" v-if="dates[0].times[index-1]">{{dates[0].times[index-1]?dates[0].times[index-1]:'-'}}</span>

                                        <span  v-else>-</span>
                                    </td>
                                    <td class="text-center" ><span class="timeClass" @click="instantRequest(dates[1],index-1)" style="cursor: pointer" v-if="dates[1].times[index-1]">{{dates[1].times[index-1]?dates[1].times[index-1]:'-'}}</span>

                                        <span  v-else>-</span></td>
                                    <td class="text-center"><span class="timeClass" @click="instantRequest(dates[2],index-1)" style="cursor: pointer" v-if="dates[2].times[index-1]">{{dates[2].times[index-1]?dates[2].times[index-1]:'-'}}</span>

                                        <span  v-else>-</span></td>
                                    <td class="text-center"><span class="timeClass" @click="instantRequest(dates[3],index-1)" style="cursor: pointer" v-if="dates[3].times[index-1]">{{dates[3].times[index-1]?dates[3].times[index-1]:'-'}}</span>

                                        <span  v-else>-</span></td>
                                    <td class="text-center"><span class="timeClass" @click="instantRequest(dates[4],index-1)" style="cursor: pointer" v-if="dates[4].times[index-1]">{{dates[4].times[index-1]?dates[4].times[index-1]:'-'}}</span>

                                        <span v-else>-</span></td>
                                </tr>
                                <template v-if="maxTimes===0 && dates.length>0">
                                    <tr >
                                        <td colspan="5" class="text-center">
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan="5" class="text-center">
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan="5" class="text-center">
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan="5" class="text-center">
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan="5" class="text-center">
                                            <button @click="requestBooking" class="btn_1">Request Booking</button>
                                        </td>
                                    </tr>
                                </template>

                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top:15px;" class="col-md-1">
                            <i @click="fetchNext" style="cursor: pointer" class="fa fa-angle-right fa-2x"></i>
                        </div>

                    </div>



                    <!-- Modal -->


                    <modal @before-open="beforeLogin" pivotX="0.2" height="auto" name="loginModal">
                        <div class="container p-2">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <i @click="$modal.hide('loginModal')" style="cursor: pointer;" class="fa fa-close fa-2x"></i>

                                </div>
                            </div>
                            <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
                            <div class="row">
                                <div class="col-md-6 text-right">
                                    <button @click.prevent="showLogin" class="btn_1" >Login</button>
                                </div>
                                <div class="col-md-6 text-left">
                                    <button @click.prevent="showRegister" class="btn_1" >Register</button>
                                </div>
                            </div>
                        </div>
                    </modal>
                    <modal pivotX="0.2"  height="auto" name="LoginModal">
                        <div class="container p-2">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <i @click="$modal.hide('LoginModal')" style="cursor: pointer;" class="fa fa-close fa-2x"></i>
                                </div>
                            </div>
                            <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
                            <login :callbackFunction="loginCallbackFunction"></login>
                        </div>
                    </modal>

                    <modal  pivotX="0.2" height="auto" name="thankyouModal">
                        <div class="container p-2">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <i @click="$modal.hide('thankyouModal')" style="cursor: pointer;" class="fa fa-close fa-2x"></i>
                                </div>
                            </div>
<!--
                            <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
-->
                            <p class="text-center">Thank you for booking an appointment</p>
                        </div>
                    </modal>
                    <modal  pivotX="0.2" height="auto" name="registerModal">
                        <div class="container p-2">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <i @click="$modal.hide('registerModal')" style="cursor: pointer;" class="fa fa-close fa-2x"></i>

                                </div>
                            </div>
                            <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
                            <register :callbackFunction="loginCallbackFunction"></register>
                        </div>
                    </modal>

                    <modal @closed="closed" @before-open="beforeOpened" :pivotX="0.2" :pivotY="0.2" height="auto" :name="'instantModal'">
                        <div class="container p-4">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <i @click="$modal.hide('instantModal')" style="cursor: pointer;" class="fa fa-close fa-2x"></i>

                                </div>
                            </div>
                            <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
                            <div style="font-size:14px;" class="row">
                                <div class="col-md-12">
                                    <h6>Appointment</h6>
                                </div>
                                <div class="col-md-12">
                                    Specialist : <strong>{{tempName?tempName:name}}</strong>
                                </div>
                                <div class="col-md-12">
                                    For : <strong>{{selectedDate}} {{selectedTime}}</strong>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <label>Reason for Visit</label>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Optional" v-model="reason"></textarea>
                                </div>
                                <div class="text-center col-md-12 mt-4">
                                    <button @click="bookInstant" class="btn_1">Book!</button>
                                </div>
                            </div>
                            <!--<form method="POST" action="/user/booking">
                                <input name="_token" v-model="csrf" type="hidden">
                                <input name="slug" v-model="slug" type="hidden">
                                <div class="row form-group">
                                    <label class="control-label">Date</label>
                                    <input class="form-control" name="date" readonly v-model="selectedDate" type="text">
                                </div>
                                <div class="row form-group">
                                    <label>Time</label>
                                    <input class="form-control" name="time" readonly v-model="selectedTime" type="text">
                                </div>
                                <div class="row form-group">
                                    <label>Reason (optional)</label>
                                    <input class="form-control" name="description"  v-model="reason" type="text">
                                </div>
                                <div class="row form-group">
                                    <button class="btn_1">Book!</button>
                                </div>
                            </form>-->
                        </div>
                    </modal>

                    <modal @closed="closed" @before-open="beforeOpened" pivotX="0.2"  pivotY="0.2" @opened="showTimePicker" height="auto" :name="'requestModal'">
                        <div class="container p-4">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <i @click="$modal.hide('requestModal')" style="cursor: pointer;" class="fa fa-close fa-2x"></i>

                                </div>
                            </div>
                            <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
                            <div style="font-size:14px;" >
                                <h6>Appointment</h6>
                                <p>

                                </p>
                                <form class="col-md-12" method="POST" action="/user/booking">
                                    <input name="_token" v-model="csrf" type="hidden">
                                    <input name="slug" v-model="slug" type="hidden">
                                    <input name="request" value="ss" type="hidden">

                                    <div class="row form-group">
                                        <label class="control-label">Specialist</label>
                                        <input readonly class="form-control" :value="tempName?tempName:name" type="text">

                                    </div>


                                    <div class="row form-group">
                                        <label class="control-label">Date</label>
                                        <input class="form-control bookingDate" autocomplete="off" id="bookingDate" name="date"   type="text">
                                    </div>
                                    <div class="row form-group">
                                        <label>Time</label>
                                        <input class="form-control bookingTime"  name="time"  id="bookingTime"  type="text">
                                    </div>
                                    <div class="row form-group">
                                        <label>Reason For Visit (optional)</label>
                                        <textarea class="form-control" name="description"  v-model="reason">
                                </textarea>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6 text-right">
                                            <button type="button" @click="bookRequest" class="btn_1">Book!</button>

                                        </div>
                                        <div class="col-md-6 text-left">
                                            <button @click="$modal.hide('requestModal')" type="button" class="btn_1 bg-dark">Cancel</button>

                                        </div>
                                    </div>
                                </form>
                                <p>
                                    By submitting this contact form, {{tempName?tempName:name}} will be informed about your request for an appointment. To enable the specialist to reach out to you we will share your contact details as per your Therapist profile.
                                </p>
                            </div>

                        </div>
                    </modal>
                    <modal :pivotX="0.2" height="auto" name="thankyouModal">
                        <div class="container p-2">
                            <div class="text-center">
                                <h2>Thank You</h2>
                                <br>
                                <p style="font-size: 16px;">
                                    You have successfully placed a booking
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button  @click="$modal.hide('thankyouModal')" class="btn_1">Continue</button>
                                </div>
                            </div>
                        </div>
                    </modal>
                    <modal :pivotX="0.2" height="auto" name="thankyouModal2">
                        <div class="container p-2">
                            <div class="text-center">
                                <h2 style="color:#74d1c6;"><i class="fa fa-check-circle-o"></i> Thank You</h2>
                                <br>
                                <p style="font-size: 16px;">
                                    Your enquiry has been sent
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button  @click="$modal.hide('thankyouModal2')" class="btn_1">Close</button>
                                </div>
                            </div>
                        </div>
                    </modal>

                </div>
            </div>
        <div class="col-md-12 text-center">
        </div>
    </div>

</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    import Login from './Login.vue';
    import Register from './Register.vue';
    import VModal from 'vue-js-modal';
    const app = {
        props:['slug','name','token'],
        name: "SearchSchedule",
        components:{
            'login':Login,
            'register':Register
        },
        data(){
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                currentDate:moment(),
                dates:[],
                maxTimes:0,
                selectedDate:null,
                selectedTime:null,
                instantToggle:false,
                requestToggle:false,
                location:window.location.href,
                reason:null,
                login:false,
                register:false,
                showPrevious:null,
                tempSlug:null,
                tempName:null
            }
        },
        methods:{
            beforeOpened(event){
                console.log(event.params.slug);
                this.tempSlug=event.params.slug;
                this.tempName=event.params.name;
                if(event.params.selectedDate!=undefined)
                    this.selectedDate=event.params.selectedDate
                if(event.params.selectedTime!=undefined)
                    this.selectedTime=event.params.selectedTime
            },
            closed(){
                this.tempSlug=null;
                this.tempName=null;
            },
            getDate(date){
                return date.split(" ");
            },
            showLogin(){
                this.$modal.hide('loginModal');
                this.$modal.show('LoginModal');
            },
            showRegister(){
                this.$modal.hide('loginModal');
                this.$modal.show('registerModal');
            },
            showTimePicker(){

                $('.bookingTime').timeDropper({
                    setCurrentTime: true,
                    meridians: true,
                    primaryColor: "#e74e84",
                    borderColor: "#e74e84",
                    minutesInterval: '15'
                });
                $('.bookingDate').datepicker().datepicker('setDate',new Date());
            },
            requestBooking(){
                /*window.location.href=`/therapist-profile/${this.slug}`;
                return;*/
                if(window.auth==='true'){

                    this.$modal.show('requestModal',{
                        slug:this.slug,
                        name:this.name
                    });
                    //window.location.href=`/therapist-profile/${this.slug}`;



                }
                else{
                    this.showPrevious='request';
                    this.$modal.show('loginModal',{
                        showPrevious:this.showPrevious,
                        slug:this.slug,
                        name:this.name
                    });
                }

            },
            beforeLogin(event){
                this.showPrevious=event.params.showPrevious;
                this.tempSlug=event.params.slug;
                this.tempName=event.params.name;
                if(event.params.selectedDate!=undefined)
                    this.selectedDate=event.params.selectedDate
                if(event.params.selectedTime!=undefined)
                    this.selectedTime=event.params.selectedTime
            },
            instantRequest(dateObj,index){
               /* window.location.href=`/therapist-profile/${this.slug}`;
                return;*/
                if(window.auth==='true'){
                    this.selectedDate=dateObj.date;
                    this.selectedTime=dateObj.times[index];
                    console.log(this.selectedDate,this.selectedTime);
                    this.$modal.show('instantModal',{
                        slug:this.slug,
                        name:this.name,
                        selectedDate:this.selectedDate,
                        selectedTime:this.selectedTime
                    });
/*
                    window.location.href=`/therapist-profile/${this.slug}`;
*/

                }
                else{
                    this.selectedDate=dateObj.date;
                    this.selectedTime=dateObj.times[index];
                    this.showPrevious='instant';
                    this.$modal.show('loginModal',{
                        showPrevious:this.showPrevious,
                        slug:this.slug,
                        name:this.name,
                        selectedDate:this.selectedDate,
                        selectedTime:this.selectedTime
                    });
                }

            },
            fetchPrevious(){
                this.dates=[];
                this.currentDate.subtract('days',5);
                this.maxTimes=0;
                axios.post('/new-schedule',{
                    date:this.currentDate.format('YYYY-MM-DD'),
                    slug:this.slug
                })
                    .then(r=>{
                        this.dates=r.data;
                        this.dates.forEach(item=>{
                            if(this.maxTimes<item.times.length)
                                this.maxTimes=item.times.length;
                            item.Date=moment(item.date,"DD-MM-YYYY").format('ddd MMM D')
                        });
                    })
            },
            fetchNext(){
                this.currentDate.add('days',5);
                this.maxTimes=0;
                this.dates=[];
                axios.post('/new-schedule',{
                    date:this.currentDate.format('YYYY-MM-DD'),
                    slug:this.slug
                })
                    .then(r=>{

                        this.dates=r.data;
                        this.dates.forEach(item=>{
                            if(this.maxTimes<item.times.length)
                                this.maxTimes=item.times.length;
                            item.Date=moment(item.date,"DD-MM-YYYY").format('ddd MMM D')
                        });
                    })
            },
            loginCallbackFunction(){
                console.log(this.showPrevious);
                this.$modal.hide('LoginModal');
                this.$modal.hide('loginModal');
                this.$modal.hide('registerModal');
                window.auth='true';
                console.log()
                if(this.showPrevious==='request')
                    this.$modal.show('requestModal',{
                        slug:this.tempSlug?this.tempSlug:this.slug,
                        name:this.tempName?this.tempName:this.name,
                    })
                else if(this.showPrevious==='instant'){
                    let data ={
                        slug:this.tempSlug?this.tempSlug:this.slug,
                        name:this.tempName?this.tempName:this.name,
                        selectedDate:this.selectedDate,
                        selectedTime:this.selectedTime
                    };
                    console.log(data);
                    this.$modal.show('instantModal',data)
                }

            },
            bookRequest(){
                let data = new FormData();
                data.append('slug',this.tempSlug?this.tempSlug:this.slug);
                data.append('time',$('#bookingTime').val());
                data.append('date',$('#bookingDate').val());
                data.append('reason',this.reason);
                data.append('request','request');
                axios.post('/user/api/booking',data)
                    .then(r=>{
                        this.$modal.hide('requestModal');
                        this.$modal.show('thankyouModal2');
                    }).catch(e=>{
                    for(let i in e.response.data.error){

                        this.$toasted.error(e.response.data.error[i][0],{
                            icon:"error",
                            onClick : (e, toastObject) => {
                                toastObject.goAway(0);
                            },
                            duration:2000,


                        });
                    }
                });
            },
            bookInstant(){
                let data = new FormData();
                data.append('slug',this.tempSlug?this.tempSlug:this.slug);
                data.append('time',this.selectedTime);
                data.append('date',this.selectedDate);
                data.append('reason',this.reason);
                axios.post('/user/api/booking',data)
                    .then(r=>{
                        this.$modal.hide('instantModal');
                        this.$modal.show('thankyouModal');
                    }).catch(e=>{
                    for(let i in e.response.data.error){

                        this.$toasted.error(e.response.data.error[i][0],{
                            icon:"error",
                            onClick : (e, toastObject) => {
                                toastObject.goAway(0);
                            },
                            duration:2000,


                        });
                    }
                });
            },
        },
        created(){
            axios.post('/new-schedule',{
                date:this.currentDate.format('YYYY-MM-DD'),
                slug:this.slug
            })
                .then(r=>{
                    this.dates=r.data;
                    this.dates.forEach(item=>{
                        if(this.maxTimes<item.times.length)
                            this.maxTimes=item.times.length;
                        item.Date=moment(item.date,"DD-MM-YYYY").format('ddd MMM D')
                    });
                })

        }
    }
    VModal.rootInstance = app
    export default  app
</script>
<style scoped>
    #mainDiv{
        font-size:10px;
    }

    .btn-my-sm{
        font-size:10px;
        padding: 3px;
    }
    .timeClass:hover{
        background-color: rgb(0, 35, 75);
        color: rgb(255, 255, 255);
        border-color: rgb(0, 35, 75);
    }

    .timeClass{
        background-color: rgb(255, 240, 75);
        padding: 6px;
        color: rgb(0, 35, 75);
        width: 70px;
        display: inline-block;
        text-align: center;
        font-size: 11px;
    }
    .table td, .table th {
        padding: 0.25rem;
    }
    .table th {
        font-size: 12px;
        font-weight: normal;
    }

</style>