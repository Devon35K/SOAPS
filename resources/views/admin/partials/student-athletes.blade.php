@php
$sports = ['Athletics', 'Badminton', 'Basketball', 'Chess', 'Football', 'Sepak Takraw', 'Swimming', 'Table Tennis', 'Taekwondo', 'Tennis', 'Volleyball'];
$statuses = ['undergraduate', 'alumni'];
@endphp

<div class="w-full max-w-7xl mx-auto">
    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.student-athletes') }}" class="mb-6 flex flex-col sm:flex-row gap-3">
        <input type="hidden" name="page" value="Student Athletes">

        <div class="flex-1">
            <input type="text" name="search" placeholder="Search by Student ID or Name..."
                   value="{{ $searchTerm }}"
                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex-1">
            <select name="sport" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Sports</option>
                @foreach($sports as $sportOption)
                    <option value="{{ $sportOption }}" {{ $sport === $sportOption ? 'selected' : '' }}>
                        {{ $sportOption }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex-1">
            <select name="campus" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Campuses</option>
                <option value="Tagum" {{ $campus === 'Tagum' ? 'selected' : '' }}>Tagum</option>
                <option value="Mabini" {{ $campus === 'Mabini' ? 'selected' : '' }}>Mabini</option>
            </select>
        </div>

        <div class="flex-1">
            <select name="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Status</option>
                @foreach($statuses as $statusOption)
                    <option value="{{ $statusOption }}" {{ $status === $statusOption ? 'selected' : '' }}>
                        {{ ucfirst($statusOption) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 transition-colors">
            <i class='bx bx-search'></i>
            Search
        </button>
    </form>

    <!-- Results Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="hidden sm:grid grid-cols-12 gap-4 bg-gray-100 text-gray-700 font-semibold py-3 px-4 text-sm">
            <div class="col-span-2">Profile</div>
            <div class="col-span-2">Student ID</div>
            <div class="col-span-3">Name</div>
            <div class="col-span-2">Sport</div>
            <div class="col-span-2">Campus</div>
            <div class="col-span-1">Status</div>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($users as $user)
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 p-4 hover:bg-gray-50 transition-colors text-sm items-center">
                    <div class="col-span-2">
                        @if($user->images->first())
                            <img src="data:{{ $user->images->first()->image_type }};base64,{{ base64_encode($user->images->first()->image) }}"
                                 alt="Profile" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                <i class='bx bx-user text-gray-600 text-xl'></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-span-2 font-medium">{{ $user->student_id }}</div>
                    <div class="col-span-3">{{ $user->full_name }}</div>
                    <div class="col-span-2">{{ $user->sport ?? 'N/A' }}</div>
                    <div class="col-span-2">{{ $user->campus ?? 'N/A' }}</div>
                    <div class="col-span-1">
                        <span class="px-2 py-1 rounded text-xs {{ $user->status === 'undergraduate' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    No students found matching your search.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $users->links() }}
        </div>
    @endif
</div>
