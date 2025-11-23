<x-layouts.app :title="__('Platforms')">
	<div class="space-y-6">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
			<div class="bg-white p-6 rounded-lg border">
				<h2 class="text-lg font-semibold mb-4">Add Platform</h2>

				<form action="{{ route('platforms.store') }}" method="POST">
					@csrf

					<div class="mb-3">
						<label class="block text-sm">Name <span class="text-red-500">*</span></label>
						<input name="name" value="{{ old('name') }}" class="w-full rounded border p-2" required>
						@error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
					</div>

					<div class="mb-3">
						<label class="block text-sm">Manufacturer</label>
						<input name="manufacturer" value="{{ old('manufacturer') }}" class="w-full rounded border p-2">
						@error('manufacturer') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
					</div>

					<div class="mb-3">
						<label class="block text-sm">Notes</label>
						<textarea name="notes" class="w-full rounded border p-2" rows="4">{{ old('notes') }}</textarea>
						@error('notes') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
					</div>

					<div>
						<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add Platform</button>
					</div>
				</form>
			</div>

			<div class="bg-white p-6 rounded-lg border">
				<h2 class="text-lg font-semibold mb-4">Platforms</h2>

				<table class="w-full text-left">
					<thead>
						<tr class="text-sm text-gray-500">
							<th class="py-2">Name</th>
							<th class="py-2">Manufacturer</th>
							<th class="py-2">Games</th>
							<th class="py-2">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($platforms as $platform)
							<tr class="border-t">
								<td class="py-3">{{ $platform->name }}</td>
								<td class="py-3">{{ $platform->manufacturer ?? '-' }}</td>
								<td class="py-3">{{ $platform->games_count }}</td>
								<td class="py-3 space-x-2">
									<button x-data @click="$dispatch('open-platform-{{ $platform->id }}')" class="text-blue-600">Edit</button>

									<form action="{{ route('platforms.destroy', $platform) }}" method="POST" class="inline" onsubmit="return confirm('Delete this platform? Games referencing it will be set to N/A.');">
										@csrf
										@method('DELETE')
										<button type="submit" class="text-red-600">Delete</button>
									</form>

									<!-- Edit modal -->
									<div x-data="{ open: false }"
										 x-on:open-platform-{{ $platform->id }}.window="open = true"
										 x-show="open"
										 style="display: none;"
										 x-cloak
										 class="fixed inset-0 z-50 flex items-center justify-center p-4">
										<div class="absolute inset-0 bg-black/50" x-on:click="open = false"></div>
										<div class="bg-white rounded-lg p-6 w-full max-w-lg z-10">
											<h3 class="text-lg font-semibold mb-4">Edit Platform</h3>
											<form method="POST" action="{{ route('platforms.update', $platform) }}">
												@csrf
												@method('PUT')

												<div class="mb-3">
													<label class="block text-sm">Name</label>
													<input name="name" value="{{ old('name', $platform->name) }}" class="w-full rounded border p-2" required>
												</div>

												<div class="mb-3">
													<label class="block text-sm">Manufacturer</label>
													<input name="manufacturer" value="{{ old('manufacturer', $platform->manufacturer) }}" class="w-full rounded border p-2">
												</div>

												<div class="mb-3">
													<label class="block text-sm">Notes</label>
													<textarea name="notes" class="w-full rounded border p-2" rows="4">{{ old('notes', $platform->notes) }}</textarea>
												</div>

												<div class="flex gap-2 justify-end">
													<button type="button" class="px-4 py-2 rounded border" x-on:click="open = false">Cancel</button>
													<button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">Save</button>
												</div>
											</form>
										</div>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="py-6 text-center text-gray-500">No platforms yet.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</x-layouts.app>
