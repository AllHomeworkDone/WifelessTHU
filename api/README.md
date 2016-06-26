# API 说明

## 总体说明

* 所有请求均为 HTTP 的 POST 请求，返回 JSON 格式数据
* 除了注册、登录和特殊说明的情况之外，所有请求均需含有 `userid` 和 `token` 字段，以进行身份的验证
* 返回码 `code` 为 `0` 时表示请求成功，`data` 字段为返回的数据，否则返回一个对应的错误信息 `message`
* 所有情况下，以下错误码对应固定的含义：
	* `-110` 未知错误
	* `-100` 参数非法
	* `-50` 服务器错误
	* `-5` 未登录
	* `-1` 参数缺失

## 注册

###### 网址

* `/api/register.php`

###### 参数

* `name` 用户名，不能超过 32 字节，不允许含有任何特殊字符
* `password` 密码，需经过 MD5 加密，大小写编码均可
* `sex` 性别，其值为 `male` `female` 之一，可为空，为空表示保密
* `email` 邮箱，可为空，不能超过 128 字节
* `icon` 头像文件名，可为空
* `type` 表明客户端的平台，其值为 `iOS` `Android` `Web` 之一

###### 返回

* `userid` 用户 ID，以后每次请求均需要此 ID
* `token` 用户登录凭据，以后每次请求均需要此 token
* `name` 用户名

## 登录

###### 网址

* `/api/login.php`

###### 参数

* `name`、`email` 二选一，参考注册 API 说明
* `password` 参考注册 API 说明
* `type` 参考注册 API 说明

###### 返回

* 参考注册 API 说明

## 登出

###### 网址

* `/api/logout.php`

###### 参数

* 无

###### 返回

* 无

## 查看用户信息

###### 网址

* `/api/view_user.php`

###### 参数

* 以下参数二选一
 * `viewing_userid` 用户 ID
 * `name` 用户名

###### 返回

* `name` 用户名
* `sex` 性别，其值为 `male` `female` `secret` 之一
* `icon` 头像文件名
* `email` 邮箱，只有当查看的是自己的信息时才会返回

## 修改用户信息

###### 网址

* `/api/edit_user.php`

###### 参数

* `name` 用户名，参考注册 API 说明
* `password` 当前密码，参考注册 API 说明
* `new_password` 新密码，不修改密码则留空
* `sex` 性别，参考注册 API 说明
* `email` 邮箱，参考注册 API 说明
* `icon` 头像文件名，参考注册 API 说明

###### 返回

* 无

## 上传图片

###### 网址

* `/api/upload_image.php`

###### 参数

* `image` 图片字符串，BASE64 编码
* `type` 图片类型，其值为 `icon` `image` 之一，分别对应用户头像，帖子图片，大小限制分别为 50KB，200KB

###### 返回

* `file_name` 头像文件名

## 发表动态

###### 网址

* `/api/post.php`

###### 参数

* `text` 动态内容
* `images` 图片文件名，以 ` | ` 作为分隔符（例如 `001 | 002 | 003` ），最多 9 个，可为空

###### 返回

* 无

## 发表评论

###### 网址

* `/api/comment.php`

###### 参数

* `postid` 动态id
* `text` 评论内容，限制在255字节

###### 返回

* 无

## 查看动态

###### 网址

* `/api/view_post.php`

###### 参数

* `postid` 动态id

###### 返回

* `post` 动态，包括：
 * `name` 发表用户姓名
 * `icon` 发表用户头像
 * `text` 状态内容
 * `images` 状态图片数组，每一个文件名对应文件为 `/images/image/xxx.jpg`
 * `create_time` 发表时间
* `comments` 评论数组，包括：
 * `name` 评论用户姓名
 * `icon` 评论用户头像
 * `text` 评论内容
 * `create_time` 发表时间

## 查看某一用户关注的人

###### 网址

* `/api/view_following.php`

###### 参数

* `viewing_userid` 用户id

###### 返回

* 数组，每个元素包括：
 * `name` 好友姓名
 * `sex` 好友性别
 * `icon` 好友头像

## 查看关注某一用户的人

###### 网址

* `/api/view_fans.php`

###### 参数

* `viewing_userid` 用户id

###### 返回

* 数组，每个元素包括：
 * `name` 好友姓名
 * `sex` 好友性别
 * `icon` 好友头像
 
## 检查是否关注某一用户

###### 网址

* `/api/check_friends.php`

###### 参数

* `viewing_userid` 用户id

###### 返回

* `true` 已经关注 或 `false` 未关注
 
## 关注用户

###### 网址

* `/api/follow.php`

###### 参数

* `tofollow_userid` 要关注的用户id

###### 返回

* 无
 
## 推荐好友
### 我关注的人还关注 & 关注我的人还关注

###### 网址

* `/api/recommend_friends.php`

###### 参数

* 无

###### 返回

* 数组，每个元素包括:
 * `userid` 用户 ID
 * `name` 姓名
 * `sex` 性别
 * `icon` 头像
* 按照好友中的关注数降序排列

## 查看某一用户动态

###### 网址

* `/api/view_user_posts.php`

###### 参数

* `viewing_userid` 所查看的用户 ID
* `start` 起始位置，从0开始
* `per_time` 一次返回的动态数量

###### 返回

* `posts` 数组，每个元素包括：
 * `postid` 动态ID
 * `text` 动态内容
 * `images` 图片，参考查看动态 API 说明
 * `create_time` 发表时间
 * `comments_num` 评论数
* `userinfo` 用户信息，参考查看用户信息 API 说明

## 查看全部好友动态

###### 网址

* `/api/view_friends_posts.php`

###### 参数

* `start` 起始位置，从0开始
* `per_time` 一次返回的动态数量

###### 返回

* `posts` 数组，每个元素包括：
 * `postid` 动态ID
 * `text` 动态内容
 * `images` 图片，参考查看动态 API 说明
 * `create_time` 发表时间
 * `create_user_userid` 动态发表用户id
 * `create_user_name` 动态发表用户姓名
 * `create_user_icon` 动态发表用户头像
 * `comments_num` 评论数

## 查看两步好友路径

###### 网址

* `/api/tow_step_friend.php`

###### 参数

* `target_username` 目标用户名

###### 返回

* 数组，每个元素代表一个中间用户a（我关注a，a关注目标用户），包括：
 * `name` 姓名
 * `sex` 性别
 * `icon` 头像
