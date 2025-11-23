<x-layouts.app :title="__('Dashboard')">
	<div class="space-y-6">
		<!-- Stats -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
			<div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
				<div class="text-xs text-gray-500">Total Games</div>
				<div class="text-2xl font-semibold mt-1">{{ $totalGames ?? 0 }}</div>
			</div>
			<div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
				<div class="text-xs text-gray-500">Total Platforms</div>
				<div class="text-2xl font-semibold mt-1">{{ $totalPlatforms ?? 0 }}</div>
			</div>
			<div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
				<div class="text-xs text-gray-500">Recent Added</div>
				<div class="text-2xl font-semibold mt-1">{{ $recentAdded->count() ?? 0 }}</div>
			</div>
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
			<!-- Add Game form -->
			<div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm">
				<h2 class="text-lg font-medium mb-4">Add Game</h2>

				<form action="{{ route('games.store') }}" method="POST" class="space-y-4">
					@csrf

					<div>
						<label class="block text-sm text-gray-600 mb-1">Title <span class="text-red-500">*</span></label>
						<input name="title" value="{{ old('title') }}" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200" required>
						@error('title') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
					</div>

					<div>
						<label class="block text-sm text-gray-600 mb-1">Genre</label>
						<input name="genre" value="{{ old('genre') }}" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200">
						@error('genre') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
					</div>

					<div>
						<label class="block text-sm text-gray-600 mb-1">Release Year</label>
						<input name="release_year" value="{{ old('release_year') }}" type="number" min="1900" max="{{ date('Y') + 1 }}" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200">
						@error('release_year') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
					</div>

					<div>
						<label class="block text-sm text-gray-600 mb-1">Platform</label>
						<select name="platform_id" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200">
							<option value="">N/A</option>
							@foreach($platforms as $platform)
								<option value="{{ $platform->id }}" @selected(old('platform_id') == $platform->id)>{{ $platform->name }}</option>
							@endforeach
						</select>
						@error('platform_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
					</div>

					<div>
						<label class="block text-sm text-gray-600 mb-1">Description</label>
						<textarea name="description" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200" rows="4">{{ old('description') }}</textarea>
						@error('description') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
					</div>

					<div>
						<button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 focus:outline-none">Add Game</button>
					</div>
				</form>
			</div>

			<!-- Games table -->
			<div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
				<h2 class="text-lg font-medium mb-4 px-2">Games</h2>

				<div class="overflow-x-auto">
					<table class="w-full text-left text-sm">
						<thead class="text-xs text-gray-500 uppercase">
							<tr>
								<th class="px-3 py-2">Title</th>
								<th class="px-3 py-2">Genre</th>
								<th class="px-3 py-2">Year</th>
								<th class="px-3 py-2">Platform</th>
								<th class="px-3 py-2">Actions</th>
							</tr>
						</thead>
						<tbody>
							@forelse($games as $game)
								<tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
									<td class="px-3 py-3 align-top">{{ $game->title }}</td>
									<td class="px-3 py-3 align-top text-gray-600">{{ $game->genre ?? '-' }}</td>
									<td class="px-3 py-3 align-top text-gray-600">{{ $game->release_year ?? '-' }}</td>
									<td class="px-3 py-3 align-top text-gray-600">{{ $game->platform->name ?? 'N/A' }}</td>
									<td class="px-3 py-3 align-top space-x-3">
										<button x-data @click="$dispatch('open-edit-{{ $game->id }}')" class="text-sm text-blue-600 hover:underline">Edit</button>

										<form action="{{ route('games.destroy', $game) }}" method="POST" class="inline" onsubmit="return confirm('Delete this game?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
										</form>

										<!-- Edit modal -->
										<div x-data="{ open: false }"
											 x-on:open-edit-{{ $game->id }}.window="open = true"
											 x-show="open"
											 style="display: none;"
											 x-cloak
											 class="fixed inset-0 z-50 flex items-center justify-center p-4">
											<div class="absolute inset-0 bg-black/40" x-on:click="open = false"></div>
											<div class="bg-white rounded-lg p-6 w-full max-w-lg z-10 shadow-lg border border-gray-100">
												<h3 class="text-lg font-medium mb-4">Edit Game</h3>
												<form method="POST" action="{{ route('games.update', $game) }}" class="space-y-3">
													@csrf
													@method('PUT')

													<div>
														<label class="block text-sm text-gray-600 mb-1">Title</label>
														<input name="title" value="{{ old('title', $game->title) }}" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200" required>
													</div>

													<div>
														<label class="block text-sm text-gray-600 mb-1">Genre</label>
														<input name="genre" value="{{ old('genre', $game->genre) }}" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200">
													</div>

													<div>
														<label class="block text-sm text-gray-600 mb-1">Release Year</label>
														<input name="release_year" value="{{ old('release_year', $game->release_year) }}" type="number" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200">
													</div>

													<div>
														<label class="block text-sm text-gray-600 mb-1">Platform</label>
														<select name="platform_id" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200">
															<option value="">N/A</option>
															@foreach($platforms as $p)
																<option value="{{ $p->id }}" @selected(old('platform_id', $game->platform_id) == $p->id)>{{ $p->name }}</option>
															@endforeach
														</select>
													</div>

													<div>
														<label class="block text-sm text-gray-600 mb-1">Description</label>
														<textarea name="description" class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-200" rows="4">{{ old('description', $game->description) }}</textarea>
													</div>

													<div class="flex justify-end gap-2">
														<button type="button" class="px-3 py-2 rounded-md border text-sm" x-on:click="open = false">Cancel</button>
														<button type="submit" class="px-3 py-2 rounded-md bg-blue-600 text-white text-sm hover:bg-blue-700">Save</button>
													</div>
												</form>
											</div>
										</div>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="5" class="py-6 text-center text-gray-500">No games yet.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</x-layouts.app>
