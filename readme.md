使用 Laravel5.5构建类似新浪微博的应用
===================
## 环境运行要求
1. 开发环境使用Homestead，请先配置；
2. PHP要求7.0以上；
3. 需要安装VirtualBox/Vagrant/Git，并启动Homestead虚拟机；
4. 配置Homestead.yaml文件

>Homestead.yaml里的配置大致可以分为以下几种：

>虚拟机设置；
SSH 秘钥登录配置；
共享文件夹配置；
站点配置；
数据库配置；
自定义变量；
接下来我们逐个讲解。

1、虚拟机设置

Homestead 支持我们对虚拟机的 IP，内存，CPU，虚拟机的默认提供者进行配置。这里我们基本不需要做任何配置，因此可以跳过。
```
ip: "192.168.10.10"
memory: 2048
cpus: 1
provider: virtualbox
```
2、SSH 秘钥登录配置

authorize 选项是指派登录虚拟机授权连接的公钥文件，此文件填写的是主机上的公钥文件地址，虚拟机初始化时，此文件里的内容会被复制存储到虚拟机的 `/home/vagrant/.ssh/authorized_keys`文件中，从而实现`SSH`免密码登录。在这里我们默认填写即可。

`authorize: ~/.ssh/id_rsa.pub`
keys 是数组选项，填写的是本机的 SSH 私钥文件地址。虚拟机初始化时，会将此处填写的所有 SSH 私钥文件复制到虚拟机的 /home/vagrant/.ssh/ 文件夹中，从而使虚拟机能共享主机上的 SSH 私钥文件，使虚拟机具备等同于主机的身份认证。此功能为 SSH 授权提供了便利，我们只需要在 GitHub 上配置一个 SSH 公钥，即可实现 GitHub 对虚拟机和主机共同认证。
具体方法请Google。

3、共享文件夹配置

我们可以通过 folders 来指明本机要映射到 Homestead 虚拟机上的文件夹。

map 对应的是我们本机的文件夹
to 对应的是 Homestead 上的文件夹。
```
folders:
    - map: ~/Code
      to: /home/vagrant/Code
```

默认 Homestead 会将我们本机的 ~/Code 文件夹映射到 /home/vagrant/Code 文件夹上。现在我们本机还没有 ~/Code 文件夹，让我们来创建一个：

> cd ~
> mkdir Code
执行成功后，同样的，我们可以通过 explorer . 命令在文件夹中打开此目录


4、站点配置

站点配置允许你在主机里，通过域名来访问虚拟机里的 Laravel 应用。如下面 sites 配置所示，将 homestead.app 映射到一个 Laravel 项目的 public 目录上。这一行配置，会命令 Homestead 为我们新建一个 Nginx 站点，并且把 Web Root 配置到指定目录下。Laravel 应用的 Nginx 站点 Web Root 配置，默认就是在根目录下的 public 目录。

```
sites:
    - map: homestead.app
      to: /home/vagrant/Code/Laravel/public
```

另外，主机里直接访问虚拟机站点，必须通过绑定 hosts 来实现。接下来我们利用 hosts 文件绑定 `homestead.app` 到虚拟机 `IP 192.168.10.10` 上。hosts 文件的完整路径为 `C:\Windows\System32\Drivers\etc\hosts`，可使用下面命令打开：

> atom C:/Windows/System32/Drivers/etc/hosts

如果你没有集成 atom 命令的话， 请使用编辑器直接打开文件，文件路径在 C:\Windows\System32\Drivers\etc\hosts 。
在 hosts 文件的最后面加入以下一行：

`192.168.10.10  homestead.app`

5、数据库配置

我们可以为 Homestead 指定数据库名称，这里使用默认设置即可。
```
databases:
    - homestead
```

6、自定义变量

最后，如果你需要自定义一些在虚拟机上可以使用的自定义变量，则可以在 variables 中进行定义。
```
variables:
    - key: APP_ENV
      value: local
```
