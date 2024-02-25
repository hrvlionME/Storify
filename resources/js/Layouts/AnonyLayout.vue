<template>
    <div>
      <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
          <!-- Primary Navigation Menu -->
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
              <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                  <Link :href="route('dashboard')">
                    <ApplicationLogo
                      class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                    />
                  </Link>
                </div>
  
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                  <!-- Render different navigation links based on authentication status -->
                  <template v-if="$page.props.auth.user">
                    <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                      Dashboard
                    </NavLink>
                  </template>
                  <template v-else>
                    <!-- Render non-authenticated navigation links here -->
                  </template>
                </div>
              </div>
            </div>
          </div>
        </nav>
  
        <!-- Page Heading -->
        <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <slot name="header" />
          </div>
        </header>
  
        <!-- Page Content -->
        <main>
          <slot />
        </main>
      </div>
    </div>
  </template>