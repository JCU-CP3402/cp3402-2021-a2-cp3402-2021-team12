### Deployment and Development Workflow

**Local Environment:**

 Before configuring the local environment, please make sure you have [Git](https://git-scm.com/), [VirtualBox](https://www.virtualbox.org/wiki/Downloads), [Vagrant ](https://www.vagrantup.com/downloads) and [Scotchbox ](https://box.scotch.io/) installed and configured since they are the main highlights of our local environment initialization.

- Open Git CMD. 
- Clone Scotchbox using their git link.
- `vagrant up`
- In the folder, transfer the wordpress files to the public folder 
- Open a code editor software ([Sublime Text](https://www.sublimetext.com/3), [Notepad++](https://notepad-plus-plus.org/downloads/)), and create a new file `wp-config.php` in `public` folder and copy-paste `wp-config-sample.php`.
- Edit the database name to ‘`scotchbox`’, user ‘`admin`’, password ‘`admin`’.
- Refresh `192.168.33.10` and proceed with `wp-config` installation.
- In the Dashboard, go to the `plugins` section and install [wp all-in-one migration extension](https://help.servmask.com/knowledgebase/install-instructions-for-file-extension/).
- After installation, use the import feature and import the latest .wpress file onto the localhost from above. 
- To add yourself as an author, go back to Git CMD and do the following: 

1. `vagrant ssh`
2. `mysql -u root -p` Enter
3. enter password.
4. INSERT INTO `databasename`.`wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES ('new ID no', 'demo', MD5('demo'), 'Your Name', 'test@yourdomain.com', '192.168.33.10', '2021-05-31 00:00:00', '', '0', 'Your Name');
5. INSERT INTO `databasename`.`wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, 'your new ID', 'wp_capabilities', 'a:1:{s:13:"administrator";s:1:"1";}');
6. INSERT INTO `databasename`.`wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, 'your new ID', 'wp_user_level', '10');

- Go back to `192.168.33.10` and refresh. 
- Login via your new credentials and you are good to go.

**Version Control:**

- We managed our version control via [Github](https://github.com/JCU-CP3402/cp3402-2021-a2-cp3402-2021-team12).
- Version control will compare the old and the new version of the code or file in order to keep track of the changes that has been made by every member of the repository.
- We pushed our commits to github via github desktop, we kept our repository up-to date by making changes to our files that we uploaded. 
- However, we did face the issue of pushing files which were more than 25mb, and hence we installed [Git LFS](https://git-lfs.github.com/) into our system for smooth commits and push to our repository.
- Steps to install git lfs:

1. In Git CMD, direct towards the repository folder in your localhost connected to the main repository on github.
2. Type:
- ~`git lfs install`
- ~`git lfs track "*.psd"` (in the " ", we input .zip as the file we need to push.)
- ~`git add .gitattributes`


**Staging:**
We used 000webhost for staging our site. [000webhost](https://in.000webhost.com/) is a free web host available for students and professionals alike.

**Web Hosting:**

- Staging – [http://13.235.247.77/](http://13.235.247.77/)
- Production- [http://65.2.128.222/](http://65.2.128.222/)

**Project Management:**

- ~[Trello](https://trello.com/b/5tmYmGPZ/cp3402-cms-group-12)
- ~[Github](https://github.com/JCU-CP3402/cp3402-2021-a2-cp3402-2021-team12)
- ~[Slack](https://join.slack.com/t/cp3402cmsgroup12/shared_invite/zt-r0k3n6it-uiaRZiqiPbzo1gOSlsTXnQ)
- ~[Discord](https://discord.gg/6CsQX2ht)
