<script setup>
    import { useRouter } from "vue-router"

    const router = useRouter()

    const logout = () => {
        localStorage.removeItem('token')
        router.push('/login')
    }
</script>
<template>
    <Suspense>
        <template #default>
            <button @click="logout">
                Log out
            </button>
        </template>
        <template #fallback> Loading... </template>
    </Suspense>
</template>
