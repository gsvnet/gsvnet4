<div class="md:flex hidden top-0 dark:bg-[#161616] bg-[#d9e0e1] min-h-screen max-h-screen w-52 flex-col pt-6 z-50 mb-8">
    <div class="dark:text-white text-black mx-auto flex-row">
        <img src="{{ asset('/images/Logo-GSV-klein-icon.png') }}" alt="Logo GSV" class="mx-auto" x-bind:class="darkMode ? 'h-12 w-12'  : 'hidden'" />
        <img src="{{ asset('/images/Logo-GSV-klein-icon-zwart.png') }}" alt="Logo GSV" class="mx-auto" x-bind:class="darkMode ? 'hidden' : 'h-12 w-12'" />
    </div>
    
    <nav>
        <h3 class="text-xl text-black dark:text-white/70 font-extralight ml-4 mt-6">
            Administratie
        </h3>
        <ul class="dark:text-white text-black mt-2 pt-4 dark:bg-[#202124] bg-[#d0d5d6] rounded-2xl ml-3 mr-3 pb-6 text-center">
            <div class="items-center flex justify-center mb-6 mt-2">
                <x-navigation.dark-toggle/>
            </div>
            <x-navigation.menu-item title="Dashboard" link="/admin"> 
                @svg('heroicon-o-home', 'h-6 w-6 mr-2')
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Uw profiel" link="/admin/gebruikers/EIGENID"> 
                @svg('heroicon-o-user-circle', 'h-6 w-6 mr-2')   
            </x-navigation.menu-item> 
            <h4 class="text-md text-gray-600 dark:text-white/70 font-extralight mb-2 pt-6 italic">
                Ledenadministratie
            </h4>
            <x-navigation.menu-item title="Updates" link="/admin/leden/updates"> 
                @svg('heroicon-o-bell', 'h-6 w-6 mr-2')
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Novieten" link="/admin/gebruikers/novieten"> 
                @svg('heroicon-o-user', 'h-6 w-6 mr-2')       
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Leden" link="/admin/gebruikers/leden"> 
                @svg('heroicon-o-users', 'h-6 w-6 mr-2') 
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Oud-leden" link="/admin/gebruikers/oud-leden"> 
                @svg('heroicon-o-user-group', 'h-6 w-6 mr-2') 
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Registreren" link="/admin/gebruikers/create"> 
                @svg('heroicon-o-user-plus', 'h-6 w-6 mr-2')   
            </x-navigation.menu-item> 
            <h4 class="text-md text-gray-600 dark:text-white/70 font-extralight mb-2 pt-6 italic">
                Activiteiten
            </h4>
            <x-navigation.menu-item title="Activiteiten" link="/admin/events"> 
                @svg('heroicon-o-calendar-days', 'h-6 w-6 mr-2')
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Toevoegen" link="/admin/events/create"> 
                @svg('heroicon-o-squares-plus', 'h-6 w-6 mr-2')
            </x-navigation.menu-item> 
            <h4 class="text-md text-gray-600 dark:text-white/70 font-extralight mb-2 pt-6 italic">
                Overig
            </h4>
            <x-navigation.menu-item title="Commissies" link="/admin/commissies"> 
                @svg('heroicon-o-briefcase', 'h-6 w-6 mr-2')
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="GSVdocs" link="/admin/files"> 
                @svg('heroicon-o-document-text', 'h-6 w-6 mr-2')
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Senaten" link="/admin/senaten"> 
                @svg('heroicon-o-bug-ant', 'h-6 w-6 mr-2')
            </x-navigation.menu-item> 
            <div class="items-center justify-center flex">
                <form method="POST" action="{{ route('uitloggen') }}">
                    @csrf
                    
                    <button type="submit" class="flex flex-row dark:text-white text-black ml-6 mt-2 hover:cursor-pointer hover:text-black/70 dark:hover:text-white/70">
                        <p class="text-xs my-auto mr-2 mx-auto">
                            Log uit
                        </p>
                        @svg('heroicon-o-arrow-right-on-rectangle', 'h-6 w-6')
                    </button>
                </form>
            </div>
        </ul>
    </nav>
</div>