<template class="bg-white">
    <header> 
        <Navbar/>
    </header>

    <main class="bg-white p-2">
        <slot />
        <Notifications />
    </main>
</template>