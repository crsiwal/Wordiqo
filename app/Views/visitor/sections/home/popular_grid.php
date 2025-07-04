<!-- Popular/Latest Articles Section with Sidebar -->
<div class="container mx-auto px-4 mb-16">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Main Article Grid -->
        <div class="flex-1">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold leading-relaxed">Popular Articles</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($latestPosts as $post): ?>
                    <article class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                        <?php if ($post['thumbnail']): ?>
                            <img src="<?= str_replace('/raw/', '/thumb/', $post['thumbnail']); ?>" alt="<?= esc($post['title']) ?>" class="w-full h-40 object-cover">
                        <?php endif; ?>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-block bg-pink-100 text-pink-600 text-xs font-semibold px-3 py-1 rounded-full mr-2 leading-relaxed"><?= esc($post['category_name'] ?? '') ?></span>
                                <span class="text-xs text-gray-400 font-medium leading-relaxed"><?= date('M d, Y', strtotime($post['published_at'])) ?></span>
                            </div>
                            <h3 class="text-base font-bold mb-1 line-clamp-2 leading-relaxed">
                                <a href="<?= base_url('post/' . $post['slug']) ?>" class="text-gray-900 hover:text-blue-600">
                                    <?= esc($post['title']) ?>
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-3 line-clamp-2 leading-relaxed">
                                <?= !empty($post['description']) ? esc(character_limiter(strip_tags($post['description']), 80)) : "" ?>
                            </p>
                            <div class="flex items-center mt-auto pt-2">
                                <?php if (!empty($post['author_avatar'])): ?>
                                    <img src="<?= esc($post['author_avatar']) ?>" alt="<?= esc($post['author_name'] ?? 'Author') ?>" class="w-8 h-8 rounded-full mr-3 object-cover">
                                <?php else: ?>
                                    <div class="w-8 h-8 rounded-full mr-3 bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <span class="font-semibold text-gray-900 text-sm leading-relaxed block"><?= esc($post['author_name'] ?? 'Author') ?></span>
                                    <span class="block text-xs text-gray-400 font-normal leading-relaxed"><?= esc($post['author_role'] ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Sidebar (Desktop Only) -->
        <aside class="hidden md:block w-full md:w-64 flex-shrink-0 mt-12">
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h3 class="text-lg font-bold mb-4 leading-relaxed">All Categories</h3>
                <ul class="space-y-2">
                    <?php foreach ($categories as $category): ?>
                        <li class="flex items-center justify-between">
                            <a href="<?= base_url('category/' . $category['slug']) ?>" class="text-gray-700 hover:text-blue-600 font-medium leading-relaxed">
                                <?= esc($category['name']) ?>
                            </a>
                            <span class="bg-gray-100 text-xs px-2 py-1 rounded-full ml-2 text-gray-500 font-semibold leading-relaxed"><?= $category['post_count'] ?? 0 ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bg-gradient-to-br from-pink-100 to-blue-100 rounded-xl shadow-md p-6 flex flex-col items-center text-center">
                <h4 class="text-lg font-bold mb-2 leading-relaxed">Join Membership</h4>
                <p class="text-gray-600 mb-4 text-sm leading-relaxed">Want to access our <span class="text-pink-600 font-semibold">premium</span> content? Sometimes features require a short description.</p>
                <a href="#" class="px-6 py-2 bg-pink-600 text-white rounded-lg font-semibold shadow hover:bg-pink-700 transition mb-2 leading-relaxed">Register Now</a>
                <a href="#" class="px-6 py-2 bg-white text-pink-600 border border-pink-600 rounded-lg font-semibold shadow hover:bg-pink-50 transition leading-relaxed">Contact Us</a>
            </div>
        </aside>
    </div>
</div>