<?php

use App\Events\NotificationOrder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admins\DashboardControntroller;
use App\Models\Role;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// login
Route::post('/login_new', [LoginController::class, 'loginUserNew'])->name('login.new');

// login with social provider
Route::get('login/{provider}', [LoginController::class, 'redireactToProvider'])->name('login.provider');
Route::get('auth/callback/{provider}', [LoginController::class, 'handleProviderCallback']);

// admin 
Route::prefix('admin')->middleware('auth', 'managestaff')->group(function () {
    Route::resource('/dashboard', 'App\Http\Controllers\Admins\DashboardControntroller');
    Route::resource('/slide', 'App\Http\Controllers\Admins\SlideController');

    // trang đơn hàng
    Route::get('/detail-order/{id}', [App\Http\Controllers\Admins\OrderControtroller::class, 'index_detail_order'])->name('order.detail.index');
    Route::get('/confirm-order/{id}', [App\Http\Controllers\Admins\OrderControtroller::class, 'confirmOrderTransactions'])->name('order.confirm');
    Route::get('/index-order', [App\Http\Controllers\Admins\OrderControtroller::class, 'index_order'])->name('order.index.new');
    Route::get('/order/transport/delivered', [App\Http\Controllers\Admins\OrderControtroller::class, 'deliveredTable'])->name('order.transport.delivered');
    Route::get('/order/transport/confirm/{id_order}', [App\Http\Controllers\Admins\OrderControtroller::class, 'confirmTransport'])->name('order.transport.confirm');
    Route::get('/order/transport', [App\Http\Controllers\Admins\OrderControtroller::class, 'indexTransport'])->name('order.transport.index');
    Route::get('/order/bill/{id}', [App\Http\Controllers\Admins\OrderControtroller::class, 'printBillOrder'])->name('order.export.bill');
    // Route::post('/order/cancel', [App\Http\Controllers\Admins\OrderControtroller::class, 'cancelOrder'])->name('order.cancel');
    // Route::get('/order/list_order', [App\Http\Controllers\Admins\OrderControtroller::class, 'getListConfirmOrder'])->name('order.confirm.listData');

    // bình luận
    Route::get('/comment/reply', [App\Http\Controllers\Admins\CommentController::class, 'replyComment'])->name('admin.comment.reply');
    Route::get('/comment/change-browse', [App\Http\Controllers\Admins\CommentController::class, 'changeBrowse'])->name('admin.change.browse');
    Route::get('/comment', [App\Http\Controllers\Admins\CommentController::class, 'indexShowComment'])->name('admin.comment.index');
    Route::get('/comment/delete/{id}', [App\Http\Controllers\Admins\CommentController::class, 'deleteComment'])->name('admin.comment.delete');

    // hồ sơ
    Route::get('/profile', [App\Http\Controllers\Global\ProfileController::class, 'indexMyProfileAdmin'])->name('admin.profile.index');

    // quản lí bài viết
    Route::get('/manage-post',[App\Http\Controllers\Personal\PostController::class, 'indexPostManage'])->name('admin.post.index');
});


// manage
Route::prefix('admin/manage')->middleware('auth', 'manage')->group(function () {
    Route::resource('/category', 'App\Http\Controllers\Admins\Manages\CategoryController');
    Route::post('/category/{category}', [App\Http\Controllers\Admins\Manages\CategoryController::class, 'updateUploadFile'])->name('category.updateUploadFile');

    // proucts
    Route::get('/products/list', [App\Http\Controllers\Admins\Manages\ProductController::class, 'getListData'])->name('products.listData');
    Route::get('/item/list', [App\Http\Controllers\Admins\Manages\PersonalItemController::class, 'getListDataItem'])->name('item.listData');

    // thêm sản phẩm
    Route::get('/addproduct', [App\Http\Controllers\Admins\Manages\AddProductController::class, 'index'])->name('products.addproduct');
    Route::post('/addproduct/checkExistProduct', [App\Http\Controllers\Admins\Manages\AddProductController::class, 'checkExistProduct'])->name('products.addproduct.checkExistProduct');
    Route::post('/addproduct/checkExistArchive', [App\Http\Controllers\Admins\Manages\AddProductController::class, 'checkExistArchive'])->name('products.addproduct.checkExistArchive');
    Route::post('/addproduct/addInfProduct', [App\Http\Controllers\Admins\Manages\AddProductController::class, 'addInfProduct'])->name('products.addproduct.addInfProduct');

    // ảnh sản phẩm
    Route::get('/imageproduct/list', [App\Http\Controllers\Admins\Manages\ImagesProductsController::class, 'getAllImage'])->name('imagesproduct.getallimage');
    Route::resource('/imageproduct', 'App\Http\Controllers\Admins\Manages\ImagesProductsController');

    // list bánh kem
    Route::resource('/products', 'App\Http\Controllers\Admins\Manages\ProductController');

    // list vật dụng bánh kem
    Route::resource('/item', 'App\Http\Controllers\Admins\Manages\PersonalItemController');

    // kho hàng
    Route::get('/archive/list', [App\Http\Controllers\Admins\Manages\ArchiveController::class, 'getListArchive'])->name('archive.listarchive');
    Route::resource('/archive', 'App\Http\Controllers\Admins\Manages\ArchiveController');

    // người dùng
    Route::get('/user/staff', [App\Http\Controllers\Admins\Manages\UserController::class, 'indexStaff'])->name('user.staff.index');
    Route::get('/user/view/staff/{id_user}', [App\Http\Controllers\Admins\Manages\UserController::class, 'view_infor_staff'])->name('user.staff.view');
    Route::get('/user/delete/{id_user}', [App\Http\Controllers\Admins\Manages\UserController::class, 'deleteUser'])->name('user.delete');
    Route::get('/user/customer', [App\Http\Controllers\Admins\Manages\UserController::class, 'indexCustomer'])->name('user.customer.index');
});

// frontend view user

// liên hệ
Route::get('/contact', [App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact.index');

// HOME
Route::get('/pet/{idpet}', [App\Http\Controllers\Frontend\InformationController::class, 'getInfPet'])->name('infor.getInfPet');
Route::resource('/', 'App\Http\Controllers\Frontend\HomeController');
// Route::get('/home', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

// Chi tiết sản phẩmm
Route::get('detailproduct/{product_id}', [App\Http\Controllers\Admins\Manages\ProductController::class, 'detailProduct'])->name('product.detailproduct');

// cửa hàng
route::get('/store', [App\Http\Controllers\Frontend\StoreController::class, 'index'])->name('store.index');
route::get('/store/category/{category_id}', [App\Http\Controllers\Frontend\StoreController::class, 'getProductsCategory'])->name('store.category');

// wishlist
route::get('/wishlist', [App\Http\Controllers\Frontend\InformationController::class, 'showWishlist'])->name('wishlist.index');

// compare
route::get('/compare', [App\Http\Controllers\Frontend\InformationController::class, 'showCompare'])->name('compare.index');
route::get('/compare/list_product', [App\Http\Controllers\Frontend\InformationController::class, 'getListsProduct'])->name('compare.listsproduct');

//Giỏ hàng
route::get('/cart', [App\Http\Controllers\Admins\CartController::class, 'indexViewUser'])->name('cart.user.index');
route::post('/add-list-cart', [App\Http\Controllers\Admins\CartController::class, 'addListCart'])->name('cart.add.list');
route::post('/add-cart', [App\Http\Controllers\Admins\CartController::class, 'addCart'])->name('cart.add');
route::post('/sub-cart', [App\Http\Controllers\Admins\CartController::class, 'subCart'])->name('cart.sub');
route::get('/delete-cart/{id_cart}', [App\Http\Controllers\Admins\CartController::class, 'deleteCart'])->name('cart.delete');
route::post('/main-cart-update', [App\Http\Controllers\Admins\CartController::class, 'mainCartUpdate'])->name('cart.main.list.update');
route::post('/update-cart', [App\Http\Controllers\Admins\CartController::class, 'updateInforCart'])->name('cart.update');
route::get('/delete-all-cart', [App\Http\Controllers\Admins\CartController::class, 'deleteAllCart'])->name('cart.delete.all');
route::get('/update-check-cart', [App\Http\Controllers\Admins\CartController::class, 'updateCheckCart'])->name('cart.update.check');

// Thanh toán
route::post('/payment/online', [App\Http\Controllers\Admins\PaymentController::class, 'paymentOnline'])->name('payment.online');
route::get('/create-payment', [App\Http\Controllers\Admins\PaymentController::class, 'createPayment'])->name('payment.create');
route::get('/payment-return', [App\Http\Controllers\Admins\PaymentController::class, 'paymentReturn'])->name('payment.return');

// trang ca nhan
Route::prefix('/personal')->middleware('auth')->group(function () {
    // trang home
    Route::get('/home', [App\Http\Controllers\Personal\PersonalController::class, 'indexHome'])->name('personal.home.index');

    // order
    Route::get('/order-my', [App\Http\Controllers\Personal\PersonalController::class, 'indexOrderMy'])->name('personal.ordermy.index');

    // Bài viết
    Route::get('/posts-my', [App\Http\Controllers\Personal\PostController::class, 'indexPostsMy'])->name('personal.post.index');
    Route::get('/posts-my/create', [App\Http\Controllers\Personal\PostController::class, 'indexCreatePost'])->name('personal.post.create.index');
    Route::post('/posts-my/create-form', [App\Http\Controllers\Personal\PostController::class, 'inforCreatePost'])->name('personal.post.infor');
    Route::get('/posts-my/edit/{id}', [App\Http\Controllers\Personal\PostController::class, 'indexEditPost'])->name('personal.post.edit.index');
    Route::post('/posts-my/edit-form/{id}', [App\Http\Controllers\Personal\PostController::class, 'EditPost'])->name('personal.post.edit.form');
    Route::get('/posts-my/delete/{id}', [App\Http\Controllers\Personal\PostController::class, 'deletePost'])->name('personal.delete.post');
    Route::get('/posts-my/change/{id}', [App\Http\Controllers\Personal\PostController::class, 'changePost'])->name('personal.change.post');
    Route::get('/posts-my/change/{id}', [App\Http\Controllers\Personal\PostController::class, 'changePost'])->name('personal.change.post');

    // tin nhắn
    Route::get('/messages', [App\Http\Controllers\Personal\MessagesController::class, 'indexMessages'])->name('personal.messages.index');
    Route::get('/messages/box-chat/{id}', [App\Http\Controllers\Personal\MessagesController::class, 'showBoxChat'])->name('personal.messages.box.chat');
    Route::post('/messages/send-messages', [App\Http\Controllers\Personal\MessagesController::class, 'sendMessages'])->name('personal.messages.send');

    // thiết lập
    Route::get('/setting', [App\Http\Controllers\Personal\PersonalController::class, 'indexSetting'])->name('personal.setting.index');
    Route::post('/setting/password', [App\Http\Controllers\Personal\PersonalController::class, 'settingPassword'])->name('personal.setting.password');
});

// bài viết chi tiết
Route::get('/detail-post/{id}', [App\Http\Controllers\Personal\PostController::class, 'seenDetailPost'])->name('post.detail');

// comment bài viết
Route::post('/comment-post', [App\Http\Controllers\Personal\PostController::class, 'addCommentPost'])->name('post.comment');

// show tất cả commen của 1 bài viết
Route::get('/comment-post/show-all', [App\Http\Controllers\Personal\PostController::class, 'showAllCommentPost'])->name('post.comment.show.all');

// like bài viết
Route::get('/like-post', [App\Http\Controllers\Personal\PostController::class, 'likePost'])->name('post.like');

// comment
Route::get('/comments', [App\Http\Controllers\Frontend\DetailProductController::class, 'showAllComment'])->name('comments.showall');
Route::post('/send-comments', [App\Http\Controllers\Frontend\DetailProductController::class, 'sendComment'])->name('comments.send');

// cộng đồng => bàu viết
Route::get('/community', [App\Http\Controllers\Frontend\CommunityController::class, 'index'])->name('community.index');
Route::get('/community/tag-search', [App\Http\Controllers\Frontend\CommunityController::class, 'searchTagPost'])->name('community.search.tag.post');

// Thêm bạn bè
Route::get('/add-friend', [App\Http\Controllers\Golobal\FriendController::class, 'addFriend'])->name('friend.add');

// route có xác thực
Route::middleware(['auth'])->group(function () {
    // xử lý trạng thái cho user
    Route::post('/status-user/online', [App\Http\Controllers\Global\UserStatusCotroller::class, 'UserOnline'])->name('status.user.online');
    Route::post('/status-user/offline', [App\Http\Controllers\Global\UserStatusCotroller::class, 'UserOffline'])->name('status.user.offline');

    // Xem trang người dùng
    Route::get('/page-personal/{id}', [App\Http\Controllers\Global\ProfileController::class, 'indexPersonalPage'])->name('personal.page.index');

    // video call
    Route::get('/video-call/get_infor_callee', [App\Http\Controllers\Personal\MessagesController::class, 'getInforCallee'])->name('video-call.infor');

    // lấy token video call
    Route::get('/video-call/get_token', [App\Http\Controllers\Personal\MessagesController::class, 'getToken'])->name('video-call.get_token');

    // chinh sua thong in ca nhan
    Route::post('/profile/edit/{id_user}', [App\Http\Controllers\Global\ProfileController::class, 'MyProfileAdminEdit'])->name('admin.profile.edit');
});
