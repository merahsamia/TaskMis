<template>
    <div class="dropdown mx-2">

        
        <a class="text-secondary" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bell" id="notification-icon"></i>
            <span id="notification-count">{{ unread_notifications.length  }}</span>
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li v-for="(unread, index) in unread_notifications" :key="index">
                <a class="dropdown-item" href="#">
                    {{ unread.data.message }}  -  {{ unread.data.title }}
                </a></li>
            
        </ul>
    </div>
</template>

<script>

export default {
    computed: {
        unread_notifications() {
            return this.$store.getters.unread_notifications
        }
    },
    mounted() {
        this.$store.dispatch('getUnreadNotifications')
    },
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