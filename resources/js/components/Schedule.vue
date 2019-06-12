<template>
    <div id="mainDiv" class="col-md-12">
            <div class="row">

            <div class="col-md-1">
                <i @click="fetchPrevious" style="cursor: pointer" class="fa fa-arrow-left"></i>
            </div>
            <div class="col-md-10 table-responsive ">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th v-for="date in dates">{{date.Date}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="index in this.maxTimes" :key="index">
                        <td><span class="timeClass" @click="instantRequest(dates[0],index-1)"  style="cursor: pointer" v-if="dates[0].times[index-1]">{{dates[0].times[index-1]?dates[0].times[index-1]:'-'}}</span>

                        <span v-else>-</span>
                        </td>
                        <td><span class="timeClass" @click="instantRequest(dates[1],index-1)" style="cursor: pointer" v-if="dates[1].times[index-1]">{{dates[1].times[index-1]?dates[1].times[index-1]:'-'}}</span>

                            <span v-else>-</span></td>
                        <td><span class="timeClass" @click="instantRequest(dates[2],index-1)" style="cursor: pointer" v-if="dates[2].times[index-1]">{{dates[2].times[index-1]?dates[2].times[index-1]:'-'}}</span>

                            <span v-else>-</span></td>
                        <td><span class="timeClass" @click="instantRequest(dates[3],index-1)" style="cursor: pointer" v-if="dates[3].times[index-1]">{{dates[3].times[index-1]?dates[3].times[index-1]:'-'}}</span>

                            <span v-else>-</span></td>
                        <td><span class="timeClass" @click="instantRequest(dates[4],index-1)" style="cursor: pointer" v-if="dates[4].times[index-1]">{{dates[4].times[index-1]?dates[4].times[index-1]:'-'}}</span>

                            <span v-else>-</span></td>
                    </tr>
                    <tr v-if="maxTimes===0 && dates.length>0">
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-1">
                <i @click="fetchNext" style="cursor: pointer" class="fa fa-arrow-right"></i>
            </div>
                <div class="col-md-12 text-center">
                    <button @click="requestBooking" class="btn_1">Request Booking</button>
                </div>
        </div>



        <!-- Modal -->


        <modal height="auto" name="loginModal">
            <div class="container p-2">
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
        <modal height="auto" name="LoginModal">
            <div class="container p-2">
                <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
                <login></login>
            </div>
        </modal>
        <modal height="auto" name="registerModal">
            <div class="container p-2">
                <p class="text-center h6">Book appointment - <span class="text-primary">in less than 60 seconds</span></p>
                <register></register>
            </div>
        </modal>

        <modal height="auto" name="instantModal">
            <div class="container p-4">
                <form method="POST" action="/user/booking">
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
                </form>
            </div>
        </modal>

        <modal  @opened="showTimePicker" height="auto" name="requestModal">
            <div class="container p-4">
                <form method="POST" action="/user/booking">
                    <input name="_token" v-model="csrf" type="hidden">
                    <input name="slug" v-model="slug" type="hidden">
                    <input name="request" value="ss" type="hidden">
                    <div class="row form-group">
                        <label class="control-label">Date</label>
                        <input class="form-control" name="date"  v-model="selectedDate" type="date">
                    </div>
                    <div class="row form-group">
                        <label>Time</label>
                        <input class="form-control" name="time" id="bookingTime"  type="text">
                    </div>
                    <div class="row form-group">
                        <label>Reason (optional)</label>
                        <input class="form-control" name="description"  v-model="reason" type="text">
                    </div>
                    <div class="row form-group">
                        <button class="btn_1">Book!</button>
                    </div>
                </form>
            </div>
        </modal>

    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    import Login from './Login.vue';
    import Register from './Register.vue';
    export default {
        name: "Schedule",
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
                register:false
            }
        },
        methods:{
            showLogin(){
                this.$modal.hide('loginModal');
                this.$modal.show('LoginModal');
            },
            showRegister(){
                this.$modal.hide('loginModal');
                this.$modal.show('registerModal');
            },
            showTimePicker(){
                $('#bookingTime').timeDropper({
                    setCurrentTime: true,
                    meridians: true,
                    primaryColor: "#e74e84",
                    borderColor: "#e74e84",
                    minutesInterval: '15'
                });
            },
            requestBooking(){
                if(window.auth==='true'){

                    this.$modal.show('requestModal');



                }
                else this.$modal.show('loginModal');
            },
            instantRequest(dateObj,index){
                if(window.auth==='true'){
                    this.selectedDate=dateObj.date;
                    this.selectedTime=dateObj.times[index];
                    this.$modal.show('instantModal');
                    console.log(dateObj);

                }
                else this.$modal.show('loginModal');

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
                        console.log(r);
                        this.dates=r.data;
                        this.dates.forEach(item=>{
                            if(this.maxTimes<item.times.length)
                                this.maxTimes=item.times.length;
                            item.Date=moment(item.date,"DD-MM-YYYY").format('ddd D/M')
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
                      console.log(r);
                      this.dates=r.data;
                      this.dates.forEach(item=>{
                          if(this.maxTimes<item.times.length)
                              this.maxTimes=item.times.length;
                          item.Date=moment(item.date,"DD-MM-YYYY").format('ddd D/M')
                      });
                  })
          }
        },
        created(){
            this.slug = window.location.href.split('/').pop();
            axios.post('/new-schedule',{
                date:this.currentDate.format('YYYY-MM-DD'),
                slug:slug
            })
                .then(r=>{
                    console.log(r);
                    this.dates=r.data;
                    this.dates.forEach(item=>{
                       if(this.maxTimes<item.times.length)
                           this.maxTimes=item.times.length;
                       item.Date=moment(item.date,"DD-MM-YYYY").format('ddd D/M')
                    });
                })
            console.log(this.maxTimes);
            console.log(window.auth);
        }
    }
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
        background:#e74e84;
        border-radius: 25px;
        color:white;
    }
</style>