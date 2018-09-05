<template>
    <div>
        {{ currentUser.username }}
    </div>
</template>

<script type="text/javascript">
    
export default {
    name: 'user-profile',
    data() {
        return {
            user: {
                id: 0,
                username: '',
                email: '',
                role: {
                    id: 0,
                    name: '',
                    description: '',
                }
            }
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        }
    }
}

</script>