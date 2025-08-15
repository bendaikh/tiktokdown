<nav class="card nav">
    <small>Menu</small>
    
    <x-admin.nav-link
        href="{{route('admin.proxy')}}"
        icon="admin.icon.mini.bolt"
        text="Configure Proxies"
    />
    <x-admin.nav-link
        href="{{route('admin.appearance')}}"
        icon="admin.icon.mini.paint-brush"
        text="Appearance"
    />
    <x-admin.nav-link
        href="{{route('admin.products.index')}}"
        icon="admin.icon.mini.shopping-bag"
        text="Products"
    />
    <x-admin.nav-link
        href="{{route('admin.me')}}"
        icon="admin.icon.mini.user"
        text="My Account"
    />
    
    <x-admin.nav-dropdown 
        text="Settings" 
        icon="admin.icon.mini.cog"
        :open="request()->routeIs('admin.settings*') || request()->routeIs('admin.ai-integration*')"
    >
        <x-admin.nav-sub-link
            href="{{route('admin.settings')}}"
            text="General Settings"
        />
        <x-admin.nav-sub-link
            href="{{route('admin.ai-integration')}}"
            text="AI Integration"
        />
    </x-admin.nav-dropdown>

    <x-admin.user-dropdown />
</nav>
