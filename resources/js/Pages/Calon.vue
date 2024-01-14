<template>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Calon Anda {{ nama }}
        </h1>
    </div>
    <div class="mt-[400px]">
        <p>The current time is {{ time }}</p>
    </div>
    <Link href="/calon" class="text-blue-500 hover:underline" preserve-scroll>Refresh</Link>
</template>

<script>
export default{
    props:{
        nama: String,
        time: String
    }
}
</script>