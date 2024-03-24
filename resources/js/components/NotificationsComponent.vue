<template>
    <div class="dropdown mx-2">

        
        <a class="text-secondary" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bell" id="notification-icon"></i>
            <span id="notification-count" v-if="unread_notifications.length > 0">{{ unread_notifications.length  }}</span>
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

            <li v-if="unread_notifications.length > 0">
                <a class="dropdown-item" href="#" @click.prevent="markNotificationAsRead({id : 0})">
                    Mark all as read!
                </a>
            </li>

            <li v-for="(unread, index) in unread_notifications" :key="index">
                <a class="dropdown-item" href="#" @click.prevent="markNotificationAsRead(unread)">
                    {{ unread.data.message }}  -  {{ unread.data.title }}

                    <p>{{ $filters.myDate(unread.created_at) }}</p>
                </a>
            </li>

            <li v-if="unread_notifications.length == 0">
                <a class="dropdown-item" href="#">
                    No new notifications!
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="#" @click.prevent="getAllNotifications">
                    Show All Notifications!
                </a>
            </li>
            
        </ul>
    </div>


     <!-- Modal -->
     <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationsModalLabel">
                        All Notifications
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="d-flex justify-content-between" v-if="all_notifications.length > 0">
                        <button type="button" class="btn btn-danger btn-block" @click.prevent="clearAllNotifications">Clear All Notifications</button>                      
                    </div>

                    <div class="card my-2" v-for="(all, index) in all_notifications" :key="index">
                        <div class="card-body text-center">
                            <span> {{ all.data.message }}  -  {{ all.data.title }} </span> <br>
                            <span> {{ $filters.myDate(all.created_at) }} </span>
                        </div>                      
                    </div>

                    <div class="card my-2" v-if="all_notifications.length == 0">
                        <div class="card-body  text-center">
                            <span> No notifications yet! </span>
                        </div>
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    computed: {
        unread_notifications() {
            return this.$store.getters.unread_notifications
        },

        all_notifications() {
            return this.$store.getters.all_notifications
        },
    },

    mounted() {
        this.$store.dispatch('getUnreadNotifications')

        this.ListenToNotifications()

    },

    methods: {
        markNotificationAsRead(unread) {
            Swal.fire({
                    title: "Are you sure?",
                    text: "You want to mark notification as read!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, mark it!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch('markNotificationAsRead', unread)
                    }
                    });
        },

        getAllNotifications() {
            this.$store.dispatch('getAllNotifications')
            $('#notificationsModal').modal('show')

        },

        clearAllNotifications() {
            Swal.fire({
                    title: "Are you sure?",
                    text: "You want to clear all notification!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, clear it!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch('clearAllNotifications')
                    }
                    });
        },

        ListenToNotifications() {
            Echo.channel(`notification`).listen('NotificationEvent', () => {
                this.$store.dispatch('getUnreadNotifications')

            });
        },


    }
}
</script>

<style scoped> 

#notification-icon {
    line-height: 30px;
    font-size: 25px;
}

#notification-count {
    text-align: center;
    position: absolute;
    top: -6px;
    right: -6px;
    min-width: 18px;
    min-height: 19px;
    border-radius: 50%;
    background-color: red;
    color: #fff;
    line-height: 19px;
    font-family: sans-serif;
}
</style>