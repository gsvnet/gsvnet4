<div class="md:flex hidden top-0 dark:bg-[#161616] bg-[#d9e0e1] min-h-screen max-h-screen w-52 flex-col pt-6 z-50 mb-8">
    <div class="dark:text-white text-black mx-auto flex-row">
        <img src="{{ asset('/images/Logo-GSV-klein-icon.png') }}" alt="Logo GSV" class="mx-auto" x-bind:class="darkMode ? 'h-12 w-12'  : 'hidden'" />
        <img src="{{ asset('/images/Logo-GSV-klein-icon-zwart.png') }}" alt="Logo GSV" class="mx-auto" x-bind:class="darkMode ? 'hidden' : 'h-12 w-12'" />
    </div>
    
    <nav>
        <h3 class="text-xl text-black dark:text-white font-extralight ml-4 mt-6">
            Administratie
        </h3>
        <ul class="dark:text-white text-black mt-2 pt-4 dark:bg-[#202124] bg-[#d0d5d6] rounded-2xl ml-3 mr-3 pb-6 text-center">
            <div class="items-center flex justify-center mb-6 mt-2">
                <x-navigation.dark-toggle/>
            </div>
            <x-navigation.menu-item title="Dashboard" link="/admin"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.1875L21.4501 10.275L21.0001 11.625H20.25V20.25H3.75005V11.625H3.00005L2.55005 10.275L12 3.1875ZM5.25005 10.125V18.75H18.75V10.125L12 5.0625L5.25005 10.125Z" fill="currentColor"/>
                </svg>
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Uw profiel" link="/admin/gebruikers/EIGENID"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>    
            </x-navigation.menu-item> 
            <h4 class="text-md text-gray-600 dark:text-white font-extralight mb-2 pt-6 italic">
                Ledenadministratie
            </h4>
            <x-navigation.menu-item title="Updates" link="/admin/leden/update"> 
                <svg fill="currentColor" class="h-6 w-6 mr-2" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
                    <path d="M18,18H8a1,1,0,0,1-1-1V12.41l1.29,1.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-3-3h0a1.15,1.15,0,0,0-.33-.21.94.94,0,0,0-.76,0,1.15,1.15,0,0,0-.33.21h0l-3,3a1,1,0,0,0,1.42,1.42L5,12.41V17a3,3,0,0,0,3,3H18a1,1,0,0,0,0-2Z"></path><path d="M21.71,10.29a1,1,0,0,0-1.42,0L19,11.59V7a3,3,0,0,0-3-3H6A1,1,0,0,0,6,6H16a1,1,0,0,1,1,1v4.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3h0a1.15,1.15,0,0,0,.33.21.94.94,0,0,0,.76,0,1.15,1.15,0,0,0,.33-.21h0l3-3A1,1,0,0,0,21.71,10.29Z"></path>
                </svg>
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Leden" link="/admin/gebruikers/leden"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>    
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Oud-leden" link="/admin/gebruikers/oud-leden"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>    
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Novieten" link="/admin/gebruikers/novieten"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>    
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Registreren" link="/admin/gebruikers/create"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12H20M12 4V20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </x-navigation.menu-item> 
            <h4 class="text-md text-gray-600 dark:text-white font-extralight mb-2 pt-6 italic">
                Activiteiten
            </h4>
            <x-navigation.menu-item title="Activiteiten" link="/admin/events"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9H21M17 13.0014L7 13M10.3333 17.0005L7 17M7 3V5M17 3V5M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Toevoegen" link="/admin/events/create"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12H20M12 4V20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </x-navigation.menu-item> 
            <h4 class="text-md text-gray-600 dark:text-white font-extralight mb-2 pt-6 italic">
                Overig
            </h4>
            <x-navigation.menu-item title="Commissies" link="/admin/commissies"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 9C2 7.89543 2.89543 7 4 7H20C21.1046 7 22 7.89543 22 9V20C22 21.1046 21.1046 22 20 22H4C2.89543 22 2 21.1046 2 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 7V4C16 2.89543 15.1046 2 14 2H10C8.89543 2 8 2.89543 8 4V7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22 12H2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7 12V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17 12V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> 
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="GSVdocs" link="/admin/files"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 7V13.8C19 14.9201 19 15.4802 18.782 15.908C18.5903 16.2843 18.2843 16.5903 17.908 16.782C17.4802 17 16.9201 17 15.8 17H12.2C11.0799 17 10.5198 17 10.092 16.782C9.71569 16.5903 9.40973 16.2843 9.21799 15.908C9 15.4802 9 14.9201 9 13.8V6.2C9 5.0799 9 4.51984 9.21799 4.09202C9.40973 3.71569 9.71569 3.40973 10.092 3.21799C10.5198 3 11.0799 3 12.2 3H15M19 7L15 3M19 7H16.6C16.0399 7 15.7599 7 15.546 6.89101C15.3578 6.79513 15.2049 6.64215 15.109 6.45399C15 6.24008 15 5.96005 15 5.4V3M5 7V14.6C5 16.8402 5 17.9603 5.43597 18.816C5.81947 19.5686 6.43139 20.1805 7.18404 20.564C8.03969 21 9.15979 21 11.4 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> 
            </x-navigation.menu-item> 
            <x-navigation.menu-item title="Senaten" link="/admin/senaten"> 
                <svg fill="currentColor" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.105,9.553a1,1,0,0,1,1.342-.448l2,1a1,1,0,0,1-.894,1.79l-2-1A1,1,0,0,1,7.105,9.553Zm8.448-.448-2,1a1,1,0,0,0,.894,1.79l2-1a1,1,0,1,0-.894-1.79Zm-.328,5.263a4,4,0,0,1-6.45,0,1,1,0,0,0-1.55,1.264,6,6,0,0,0,9.55,0,1,1,0,1,0-1.55-1.264ZM23,2V12A11,11,0,0,1,1,12V2a1,1,0,0,1,1.316-.949l4.229,1.41a10.914,10.914,0,0,1,10.91,0l4.229-1.41A1,1,0,0,1,23,2ZM21,12a9,9,0,1,0-9,9A9.029,9.029,0,0,0,21,12Z"/>
                </svg> 
            </x-navigation.menu-item> 
            <div class="items-center justify-center flex">
                <form method="POST" action="{{ route('uitloggen') }}">
                    @csrf
                    
                    <button type="submit" class="flex flex-row dark:text-white text-black ml-6 mt-2 hover:cursor-pointer hover:text-black/70 dark:hover:text-white/70">
                        <p class="text-xs my-auto mr-2 mx-auto">
                            Log uit
                        </p>
                        <svg class="h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 20H6C4.89543 20 4 19.1046 4 18L4 6C4 4.89543 4.89543 4 6 4H14M10 12H21M21 12L18 15M21 12L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
        </ul>
    </nav>
</div>