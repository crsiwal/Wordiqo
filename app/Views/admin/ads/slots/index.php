<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>
<!-- Header Section with Animated Background -->
<div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 p-8">
    <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-white">
            <h1 class="text-5xl font-bold leading-tight mb-2">Ad Slots</h1>
            <p class="text-blue-100 text-xl">Manage advertising spaces throughout your website</p>
            <div class="flex items-center mt-4 text-blue-100">
                <span class="flex items-center mr-6">
                    <i class="fas fa-layer-group mr-2"></i>
                    <span><?php echo count($adSlots) ?> Ad Slots</span>
                </span>
                <span class="flex items-center">
                    <i class="fas fa-ad mr-2"></i>
                    <span><?php echo array_sum(array_column($adSlots, 'ad_count')) ?? 0 ?> Total Ads</span>
                </span>
            </div>
        </div>
        <?php if ($userRole === 'admin'): ?>
            <a href="<?php echo base_url('admin/ads/slots/create') ?>"
                class="group relative px-8 py-3 bg-white text-blue-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <span class="w-7 h-7 flex items-center justify-center bg-blue-100 rounded-full mr-2 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-plus"></i>
                    </span>
                    New Ad Slot
                </span>
                <span class="absolute inset-0 w-0 bg-gradient-to-r from-blue-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                <span class="absolute inset-0 w-full h-full opacity-0 group-hover:opacity-20 bg-grid-white/20 bg-grid-8 transition-opacity duration-300"></span>
            </a>
        <?php endif; ?>
    </div>

    <!-- Animated bubbles background effect -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
        <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="absolute rounded-full bg-white/30"
                style="<?php echo 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;' ?>"></div>
        <?php endfor; ?>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="mb-8 bg-white rounded-xl shadow-md p-4 transition-all duration-300 hover:shadow-lg">
    <form action="<?= base_url('admin/ads/slots') ?>" method="get" class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" name="q" value="<?= esc($queryParams['q'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search ad slots...">
        </div>
        <input type="hidden" name="sort" id="sortInput" value="<?= esc($sort ?? 'name_asc') ?>">
        <div class="relative">
            <button type="button" id="sortDropdownBtn" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-sort-amount-down mr-2"></i> Sort
            </button>
            <div id="sortDropdown" class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-20 hidden">
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 rounded-t-lg sort-option <?= ($sort === 'name_asc') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="name_asc">Name A-Z</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?= ($sort === 'name_desc') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="name_desc">Name Z-A</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?= ($sort === 'ad_count') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="ad_count">Number of Ads</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?= ($sort === 'width') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="width">Width</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 sort-option <?= ($sort === 'height') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="height">Height</button>
                <button type="button" class="block w-full text-left px-4 py-2 hover:bg-blue-100 rounded-b-lg sort-option <?= ($sort === 'created_at') ? 'bg-blue-100 text-blue-700 font-semibold' : '' ?>" data-value="created_at">Recently Created</button>
            </div>
        </div>
        <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg">Search</button>
    </form>
</div>

<!-- Active Filters Display -->
<?php if (!empty($activeFilters['search'])): ?>
    <div class="mb-6 bg-blue-50 rounded-xl p-4 flex items-center justify-between">
        <div>
            <span class="text-gray-700 font-medium">Active filters:</span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                <i class="fas fa-search mr-1"></i>
                Search: <?= esc($activeFilters['search']) ?>
                <a href="<?= base_url('admin/ads/slots') ?>" class="ml-2 text-yellow-600 hover:text-yellow-800">
                    <i class="fas fa-times"></i>
                </a>
            </span>
        </div>
        <a href="<?= base_url('admin/ads/slots') ?>" class="text-gray-600 hover:text-gray-800 flex items-center">
            <i class="fas fa-times mr-1"></i> Clear filters
        </a>
    </div>
<?php endif; ?>

<!-- Ad Slots Grid -->
<?php if (empty($adSlots)): ?>
    <div class="bg-white rounded-xl shadow-md p-8 text-center">
        <div class="mb-4">
            <i class="fas fa-ad text-gray-300 text-5xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-700 mb-2">No ad slots found</h3>
        <p class="text-gray-500 mb-6">There are no ad slots created yet. Start by creating your first ad slot.</p>
        <?php if ($userRole === 'admin'): ?>
            <a href="<?= site_url('admin/ads/slots/create') ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Ad Slot
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($adSlots as $slot): ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                            <?= esc($slot['name']) ?>
                        </h3>
                        <div class="flex gap-1">
                            <?php if ($userRole === 'admin'): ?>
                                <a href="<?php echo base_url('admin/ads/slots/edit/' . $slot['id']) ?>"
                                    class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo base_url('admin/ads/slots/delete/' . $slot['id']) ?>"
                                    class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors"
                                    onclick="return confirm('Are you sure you want to delete this ad slot<?= $slot['ad_count'] > 0 ? '? This will affect ' . $slot['ad_count'] . ' ad(s) associated with it.' : '?' ?>')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="fas fa-link mr-2 text-gray-400"></i>
                        <span class="truncate"><?php echo esc($slot['slug']) ?></span>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-ruler-combined mr-1"></i>
                            <?= $slot['width'] ?> × <?= $slot['height'] ?> px
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $slot['is_active'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                            <i class="fas <?= $slot['is_active'] ? 'fa-check' : 'fa-ban' ?> mr-1"></i>
                            <?= $slot['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-ad text-blue-500 mr-2"></i>
                                <span><?php echo number_format($slot['ad_count'] ?? 0) ?> Ads</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-calendar-alt text-purple-500 mr-2"></i>
                                <span><?php echo date('M d, Y', strtotime($slot['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager)): ?>
        <div class="mt-8 flex justify-center">
            <?php echo $pager->links('default', 'admin_pager'); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<style>
    .bg-grid-white\/20 {
        mask-image: linear-gradient(to bottom, transparent, black);
    }

    .bg-grid-8 {
        background-size: 40px 40px;
        background-image:
            linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0px);
        }
    }
</style>

<script>
    // Sort dropdown logic
    const sortBtn = document.getElementById('sortDropdownBtn');
    const sortDropdown = document.getElementById('sortDropdown');
    sortBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        sortDropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', function(e) {
        if (!sortDropdown.classList.contains('hidden')) {
            sortDropdown.classList.add('hidden');
        }
    });
    const sortOptions = document.querySelectorAll('.sort-option');
    const sortInput = document.getElementById('sortInput');
    const searchInput = document.querySelector('input[name="q"]');
    const form = document.querySelector('form[action*="admin/ads/slots"]');
    sortOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            sortInput.value = option.dataset.value;
            sortDropdown.classList.add('hidden');
            form.submit();
        });
    });
</script>
<?php echo $this->endSection() ?>