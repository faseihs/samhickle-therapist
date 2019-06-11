<template>
    <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-left">
                    <h5>Available Times</h5>
                </div>
            <div class="col-md-1">
                <i @click="fetchPrevious" style="cursor: pointer" class="fa fa-arrow-left"></i>
            </div>
            <div class="col-md-10 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th v-for="date in dates">{{date.date}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="index in this.maxTimes" :key="index">
                        <td>{{dates[0].times[index-1]?dates[0].times[index-1]:'-'}}</td>
                        <td>{{dates[1].times[index-1]?dates[1].times[index-1]:'-'}}</td>
                        <td>{{dates[2].times[index-1]?dates[2].times[index-1]:'-'}}</td>
                        <td>{{dates[3].times[index-1]?dates[3].times[index-1]:'-'}}</td>
                        <td>{{dates[4].times[index-1]?dates[4].times[index-1]:'-'}}</td>
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
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    export default {
        name: "Schedule",
        data(){
            return {
                currentDate:moment(),
                dates:[],
                maxTimes:0
            }
        },
        methods:{
            fetchPrevious(){
                this.dates=[];
                this.currentDate.subtract('days',5);
                this.maxTimes=0;
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
                        });
                    })
            },
          fetchNext(){
              this.currentDate.add('days',5);
              this.maxTimes=0;
              this.dates=[];
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
                      });
                  })
          }
        },
        created(){
            let slug = window.location.href.split('/').pop();
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
                    });
                })
            console.log(this.maxTimes);
        }
    }
</script>
<style scoped>

</style>