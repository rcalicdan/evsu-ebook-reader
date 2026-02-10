 <x-slot name="title">My Profile - DocHub</x-slot>
 <div class="max-w-4xl mx-auto">
     <!-- Page Header -->
     <div class="mb-8">
         <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
         <p class="mt-2 text-gray-600">Manage your account information and preferences</p>
     </div>
     <!-- Profile Form Card -->
     <div class="bg-white rounded-lg shadow-md overflow-hidden">
         <!-- Profile Header with Avatar -->
         <div class="bg-university-red p-6">
             <div class="flex items-center space-x-4">
                 <div class="h-20 w-20 rounded-full bg-white flex items-center justify-center flex-shrink-0">
                     <span class="text-3xl font-bold text-university-red">JD</span>
                 </div>
                 <div class="text-white">
                     <h2 class="text-2xl font-bold">John Doe</h2>
                     <p class="text-red-100">Student</p>
                 </div>
             </div>
         </div>
         <!-- Form -->
         <form class="p-6 space-y-6">
             <!-- Personal Information Section -->
             <div>
                 <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Personal Information</h3>

                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <!-- First Name -->
                     <div>
                         <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                             First Name <span class="text-red-500">*</span>
                         </label>
                         <input type="text"
                             id="first_name"
                             name="first_name"
                             value="John"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                             required>
                     </div>

                     <!-- Last Name -->
                     <div>
                         <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                             Last Name <span class="text-red-500">*</span>
                         </label>
                         <input type="text"
                             id="last_name"
                             name="last_name"
                             value="Doe"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                             required>
                     </div>

                     <!-- Email -->
                     <div class="md:col-span-2">
                         <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                             Email Address <span class="text-red-500">*</span>
                         </label>
                         <input type="email"
                             id="email"
                             name="email"
                             value="john.doe@university.edu"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                             required>
                     </div>
                 </div>
             </div>

             <!-- Student Information Section -->
             <div>
                 <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Student Information</h3>

                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <!-- Student ID -->
                     <div>
                         <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                             Student ID <span class="text-red-500">*</span>
                         </label>
                         <input type="text"
                             id="student_id"
                             name="student_id"
                             value="2021-12345"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                             required>
                     </div>

                     <!-- Year Level -->
                     <div>
                         <label for="year_level" class="block text-sm font-medium text-gray-700 mb-2">
                             Year Level <span class="text-red-500">*</span>
                         </label>
                         <select id="year_level"
                             name="year_level"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                             required>
                             <option value="">Select Year Level</option>
                             <option value="1">1st Year</option>
                             <option value="2">2nd Year</option>
                             <option value="3" selected>3rd Year</option>
                             <option value="4">4th Year</option>
                             <option value="5">5th Year</option>
                         </select>
                     </div>

                     <!-- Program -->
                     <div class="md:col-span-2">
                         <label for="program" class="block text-sm font-medium text-gray-700 mb-2">
                             Program <span class="text-red-500">*</span>
                         </label>
                         <input type="text"
                             id="program"
                             name="program"
                             value="Bachelor of Science in Computer Science"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                             placeholder="e.g., Bachelor of Science in Computer Science"
                             required>
                     </div>
                 </div>
             </div>


             <!-- Password Section -->
             <div>
                 <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Change Password</h3>

                 <div class="grid grid-cols-1 gap-6">
                     <!-- Current Password -->
                     <div x-data="{ showPassword: false }">
                         <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                             Current Password
                         </label>
                         <div class="relative">
                             <input :type="showPassword ? 'text' : 'password'"
                                 id="current_password"
                                 name="current_password"
                                 class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                                 placeholder="Enter current password">
                             <button type="button"
                                 @click="showPassword = !showPassword"
                                 class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800 transition">
                                 <!-- Eye Icon (Show) -->
                                 <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                 </svg>
                                 <!-- Eye Slash Icon (Hide) -->
                                 <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                 </svg>
                             </button>
                         </div>
                     </div>

                     <!-- New Password -->
                     <div x-data="{ showPassword: false }">
                         <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                             New Password
                         </label>
                         <div class="relative">
                             <input :type="showPassword ? 'text' : 'password'"
                                 id="new_password"
                                 name="new_password"
                                 class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                                 placeholder="Enter new password">
                             <button type="button"
                                 @click="showPassword = !showPassword"
                                 class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800 transition">
                                 <!-- Eye Icon (Show) -->
                                 <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                 </svg>
                                 <!-- Eye Slash Icon (Hide) -->
                                 <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                 </svg>
                             </button>
                         </div>
                     </div>

                     <!-- Confirm New Password -->
                     <div x-data="{ showPassword: false }">
                         <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                             Confirm New Password
                         </label>
                         <div class="relative">
                             <input :type="showPassword ? 'text' : 'password'"
                                 id="confirm_password"
                                 name="confirm_password"
                                 class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                                 placeholder="Confirm new password">
                             <button type="button"
                                 @click="showPassword = !showPassword"
                                 class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800 transition">
                                 <!-- Eye Icon (Show) -->
                                 <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                 </svg>
                                 <!-- Eye Slash Icon (Hide) -->
                                 <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                 </svg>
                             </button>
                         </div>
                     </div>
                 </div>
             </div>
             <!-- Form Actions -->
             <div class="flex items-center justify-between pt-6 border-t">
                 <a href="/"
                     class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">

                 </a>
                 <button type="submit"
                     class="px-6 py-2 bg-university-red text-white rounded-lg font-medium hover:bg-red-700 transition shadow-md">
                     Save Changes
                 </button>
             </div>
         </form>
     </div>