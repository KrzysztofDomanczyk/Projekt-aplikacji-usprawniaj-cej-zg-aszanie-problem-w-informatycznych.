<template>

       <li class="nav-item dropdown"    id="notification">
            
            <a id="navbarDropdown " class="nav-link new dropdown-toggle" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="fas fa-bell  green-color"></i>
            </a>
            <div  id="counter" v-if="existUnseenNotificationCom">{{countNew}}</div>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              
                <a class="dropdown-item "
                    :class="{ 'unSeen': notification.seen == 0 }"
                    v-on:click="markAsSeen(notification.id)"
                    v-for="(notification, index) in notifications" 
                    :key="index" 
                    :href="notification.target">
                    
                        {{notification.content}}<br>
                        <small>{{notification.created_at}}</small>
                        <!--  -->
                </a>
 
            </div>
        </li>
</template>

<script>
    export default {
       
        mounted() {
            console.log('Component user mounted.')
            self = this;
            this.getNotifications();
        }, 
        data: function () {
            return {
                notifications:null,
                existUnseenNotification: true,
                countNew: 0
            }
        },
        computed: {
            existUnseenNotificationCom: function () {     
                return this.countNew == 0 ? false : true;
                
            }
        },
        methods: {
            getNotifications: function (event) {
            axios.get('/api/get-notifications')
                .then(function (response) {
                    self.notifications = response.data;
                    self.countUnseen();
                });
            },
            countUnseen: function () {
                 this.countNew = this.notifications.filter((item) =>  item.seen == true).length;
            },
            markAsSeen: function ($id) {
                axios.get('/api/mark-as-seen-notification/' + $id)
                .then(function (response) {
                  self.getNotifications();
                })
            },
            
        }
    }
</script>

<style lang="css">
.unSeen{
    color:#9c9c9c  !important;
}
</style>