<?php
/*
@TODO:
— auto backup system files
— rollback option for updater
*/

if (!defined('MODX_BASE_PATH')) {
    die('What are you doing? Get out of here!');
}

if (empty($_SESSION['mgrInternalKey'])) {
    return;
}
// get manager role
$internalKey = $modx->getLoginUserID('mgr');
$sid = $modx->sid;
$role = isset($_SESSION['mgrRole']) ? $_SESSION['mgrRole'] : '';
$user = isset($_SESSION['mgrShortname']) ? $_SESSION['mgrShortname'] : '';
$wdgVisibility = isset($wdgVisibility) ? $wdgVisibility : '';
$ThisRole = isset($ThisRole) ? $ThisRole : '';
$ThisUser = isset($ThisUser) ? $ThisUser : '';
$version = isset($version) ? $version : 'evocms-community/evolution';
$version = str_replace('evolution-cms/evolution', 'evocms-community/evolution', $version);
$type = isset($type) ? $type : 'tags';
$showButton = isset($showButton) ? $showButton : 'AdminOnly';
$result = '';
$feedCache = MODX_BASE_PATH . 'assets/cache/updater/';
if (!is_dir($feedCache)) {
    @mkdir($feedCache, intval($modx->getConfig('new_folder_permissions'), 8), true);
}

if ($role != 1 && $wdgVisibility == 'AdminOnly') {
} elseif ($role == 1 && $wdgVisibility == 'AdminExcluded') {
} elseif ($role != $ThisRole && $wdgVisibility == 'ThisRoleOnly') {
} elseif ($user != $ThisUser && $wdgVisibility == 'ThisUserOnly') {
} else {
    //lang
    $_lang = [];
    $plugin_path = MODX_BASE_PATH . "assets/plugins/updater/";
    include($plugin_path . 'lang/english.php');
    if (file_exists($plugin_path . 'lang/' . $modx->getConfig('manager_language') . '.php')) {
        include($plugin_path . 'lang/' . $modx->getConfig('manager_language') . '.php');
    }

    $e = $modx->event;
    if ($e->name == 'OnSiteRefresh') {
        array_map("unlink", glob($feedCache . '*.*'));
    }

    if ($e->name == 'OnManagerWelcomeHome') {
        $errorsMessage = '';
        $errors = 0;
        if (!extension_loaded('curl')) {
            $errorsMessage .= '-' . $_lang['error_curl'] . '<br>';
            $errors += 1;
            $curlNotReady = true;
        }
        if (!extension_loaded('zip')) {
            $errorsMessage .= '-' . $_lang['error_zip'] . '<br>';
            $errors += 1;
        }
        if (!extension_loaded('openssl')) {
            $errorsMessage .= '-' . $_lang['error_openssl'] . '<br>';
            $errors += 1;
        }
        if (!is_writable(MODX_BASE_PATH . 'assets/')) {
            $errorsMessage .= '-' . $_lang['error_overwrite'] . '<br>';
            $errors += 1;
        }

        // Avoid "Fatal error: Call to undefined function curl_init()"
        if (isset($curlNotReady)) {
            $output = '<div class="card-body">
                <small style="color:red;font-size:10px">' . $errorsMessage . '</small></div>';

            $widgets['updater'] = [
                'menuindex' => '1',
                'id'        => 'updater',
                'cols'      => 'col-sm-12',
                'icon'      => 'fa-exclamation-triangle',
                'title'     => $_lang['system_update'],
                'body'      => $output
            ];
            $e->addOutput(serialize($widgets));
            return;
        }

        $_SESSION['updatelink'] = md5(time());
        // if a GitHub commit feed
        if ($type == 'commits') {
            if (!class_exists('SimplePie\SimplePie')) {
                include_once MODX_MANAGER_PATH . 'media/rss/vendor/autoload.php';
            }
            $feed = new \SimplePie\SimplePie();
            $feed->set_cache_location($feedCache);
            $branchPath = 'https://github.com/' . $version . '/' . $type . '/' . $branch;
            $url = $branchPath . '.atom';
            // create Feed

            $updateButton = '';
            $feed->set_feed_url($url);
            $feed->init();
            $items = $feed->get_items(0, $commitCount ?? 20);
            if (empty($items)) {
                $items = [];
                $errorsMessage .= '-' . $_lang['error_failedtogetfeed'] . ':' . $url . '<br>';
                $errors += 1;
            }
            $updateButton .= '<div class="table-responsive" style="max-height:200px;"><table class="table data">';
            $updateButton .= '<thead><tr><th>' . $_lang['table_commitdate'] . '</th><th>' . $_lang['table_titleauthor'] . '</th><th></th></tr></thead><tbody>';

            foreach ($items as $item) {
                $commitid = $item->get_id();
                $commit = substr($commitid, strpos($commitid, "Commit/") + 7);
                $href = $item->get_link();
                $title = $item->get_title();
                $pubdate = $item->get_updated_date();
                $pubdate = $modx->toDateFormat(strtotime($pubdate));
                $author = $item->get_author();
                $updateButton .= '<tr><td><b>' . $pubdate . '</b></td><td><a href="' . $href . '" target="_blank">' . $title . '</a> (' . $author . ')</td>';
                if (($role != 1) and ($showButton == 'AdminOnly') or ($showButton == 'hide') or ($errors > 0)) {
                    $updateButton .= '<td></td></tr>';
                } else {
                    $updateButton .= '<td><a onclick="return confirm(\'' . $_lang['are_you_sure_update'] . '\')" target="_parent" title="sha: ' . $commit . '" class="btn btn-sm btn-danger" href="' . MODX_SITE_URL . $_SESSION['updatelink'] . '&sha=' . $commit . '">' . $_lang['updateButtonCommit_txt'] . '</a></td></tr>';
                }
            }

            $updateButton .= '</tbody></table></div>';

            $output = '<div class="card-body">GitHub commits for <strong>(<a target="_blank" href="' . $branchPath . '">' . $branchPath . '</a>)</strong><br>
            <small style="color:red;font-size:10px"> ' . $_lang['bkp_before_msg'] . '</small><br>
            <small style="color:red;font-size:10px">' . $errorsMessage . '</small>
                    </div>' . $updateButton;
            // Add widget to end as is always displayed for commits
            $widgets['updater'] = [
                'menuindex' => '1000',
                'id'        => 'updater',
                'cols'      => 'col-sm-12',
                'icon'      => 'fa-exclamation-triangle',
                'title'     => $_lang['system_update'],
                'body'      => $output
            ];
            $e->addOutput(serialize($widgets));
        } else {
            $output = '';

            $currentVersion = $modx->getVersionData();
            $currentMajorVersion = explode('.', $currentVersion['version']);
            $currentMajorVersion = array_shift($currentMajorVersion);

            if (!file_exists(MODX_BASE_PATH . 'assets/cache/updater/check_' . date("d") . '.json')) {
                $ch = curl_init();
                $url = 'https://api.github.com/repos/' . $version . '/' . $type;
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_REFERER, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: updateNotify widget']);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
                curl_setopt($ch, CURLOPT_TIMEOUT, 4); //timeout in 4 seconds
                $info = curl_exec($ch);
                curl_close($ch);
                if (substr($info, 0, 1) != '[') {
                    return;
                }
                $info = json_decode($info, true);
                if (!is_array($info)) {
                    $info = [];
                }
                foreach ($info as $key => $val) {
                    $names = explode('.', $val['name']);
                    if ($currentMajorVersion == array_shift($names)) {

                        $git['version'] = $val['name'];

                        if (strpos($val['name'], 'alpha')) {
                            $git['alpha'] = $val['name'];
                            continue;
                        } elseif (strpos($val['name'], 'beta')) {
                            $git['beta'] = $val['name'];
                            continue;
                        } else {
                            $git['stable'] = $val['name'];
                            break;
                        }
                    }
                }

                file_put_contents(MODX_BASE_PATH . 'assets/cache/updater/check_' . date("d") . '.json',
                    json_encode($git));
            } else {
                $git = file_get_contents(MODX_BASE_PATH . 'assets/cache/updater/check_' . date("d") . '.json');
                $git = json_decode($git, true);
            }

            if ($stableOnly == 'true') {
                if (version_compare($git['version'], $git['stable'], '!=')) {
                    $git['version'] = $git['stable'];
                }
            }

            $_SESSION['updateversion'] = $git['version'];

            if (version_compare($git['version'], $currentVersion['version'],
                    '>') && $git['version'] != '') {
                // get manager role
                $role = $_SESSION['mgrRole'];
                if (($role != 1) and ($showButton == 'AdminOnly') or ($showButton == 'hide') or ($errors > 0)) {
                    $updateButton = '';
                } else {
                    $updateButton = '<a target="_parent" onclick="return confirm(\'' . $_lang['are_you_sure_update'] . '\')" href="' . MODX_SITE_URL . $_SESSION['updatelink'] . '" class="btn btn-sm btn-danger">' . $_lang['updateButton_txt'] . ' ' . $git['version'] . '</a><br><br>';
                }

                $output = '<div class="card-body">' . $_lang['cms_outdated_msg'] . ' <strong>' . $git['version'] . '</strong> <br><br>
                    ' . $updateButton . '
                    <small style="color:red;font-size:10px"> ' . $_lang['bkp_before_msg'] . '</small>
                    <small style="color:red;font-size:10px">' . $errorsMessage . '</small></div>';

                $widgets['updater'] = [
                    'menuindex' => '1',
                    'id'        => 'updater',
                    'cols'      => 'col-sm-12',
                    'icon'      => 'fa-exclamation-triangle',
                    'title'     => $_lang['system_update'],
                    'body'      => $output
                ];

                $e->addOutput(serialize($widgets));
            }
        }
    }

    if ($e->name == 'OnPageNotFound' && isset($_GET['q'])) {
        if (empty($_SESSION['mgrInternalKey']) || empty($_SESSION['updatelink'])) {
            return;
        }
        switch ($_GET['q']) {
            case $_SESSION['updatelink']:
                $currentVersion = $modx->getVersionData();
                $commit = isset($_GET['sha']) ? $_GET['sha'] : '';
                if ($_SESSION['updateversion'] != $currentVersion['version'] || (isset($commit) && $type == 'commits')) {

                    file_put_contents(MODX_BASE_PATH . 'update.php', '<?php
function downloadFile(
    $url,
    $path
) {
    $newfname = $path;
    $file = null;
    $newf = null;
    try {
        if (ini_get("allow_url_fopen")) {
            $file = fopen($url, "rb");
            if ($file) {
                $newf = fopen($newfname, "wb");
                if ($newf) {
                    while (!feof($file)) {
                        fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                    }
                }
            }
        } elseif (function_exists("curl_version")) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $content = curl_exec($ch);
            curl_close($ch);
            file_put_contents($newfname, $content);
        }
    } catch (Exception $e) {
        $this->errors[] = array("ERROR:Download", $e->getMessage());
        return false;
    }
    if ($file) {
        fclose($file);
    }

    if ($newf) {
        fclose($newf);
    }

    return true;
}

function removeFolder($path)
{
    $dir = realpath($path);
    if (!is_dir($dir)) {
        return;
    }

    $it = new RecursiveDirectoryIterator($dir);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
        if ($file->getFilename() === "." || $file->getFilename() === "..") {
            continue;
        }
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir($dir);
}

function copyFolder(
    $src,
    $dest
) {
    $path = realpath($src);
    $dest = realpath($dest);
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
    foreach ($objects as $name => $object) {

        $startsAt = substr(dirname($name), strlen($path));
        mmkDir($dest . $startsAt);
        if ($object->isDir()) {
            mmkDir($dest . substr($name, strlen($path)));
        }

        if (is_writable($dest . $startsAt) and $object->isFile()) {
            copy((string)$name, $dest . $startsAt . DIRECTORY_SEPARATOR . basename($name));
        }
    }
}

function mmkDir(
    $folder,
    $perm = 0777
) {
    if (!is_dir($folder)) {
        mkdir($folder, $perm);
    }
}

$version = "' . $version . '";

downloadFile("https://github.com/" . $version . "/archive/" . $_GET["version"] . ".zip", "evo.zip");
$zip = new ZipArchive;
$res = $zip->open(__DIR__ . "/evo.zip");
$zip->extractTo(__DIR__ . "/temp");
$zip->close();

if ($handle = opendir(__DIR__ . "/temp")) {
    while (false !== ($name = readdir($handle))) {
        if ($name != "." && $name != "..") {
            $dir = $name;
        }
    }
    closedir($handle);
}
removeFolder(__DIR__ . "/temp/" . $dir . "/install/assets/chunks");
removeFolder(__DIR__ . "/temp/" . $dir . "/install/assets/tvs");
removeFolder(__DIR__ . "/temp/" . $dir . "/install/assets/templates");
unlink(__DIR__ . "/temp/" . $dir . "/ht.access");
unlink(__DIR__ . "/temp/" . $dir . "/README.md");
unlink(__DIR__ . "/temp/" . $dir . "/sample-robots.txt");
unlink(__DIR__ . "/temp/" . $dir . "/composer.json");

if (is_file(__DIR__ . "/assets/cache/siteManager.php")) {

    unlink(__DIR__ . "/temp/" . $dir . "/assets/cache/siteManager.php");
    include_once(__DIR__ . "/assets/cache/siteManager.php");
    if (!defined("MGR_DIR")) {
        define("MGR_DIR", "manager");
    }
    if (MGR_DIR != "manager") {
        mmkDir(__DIR__ . "/temp/" . $dir . "/" . MGR_DIR);
        copyFolder(__DIR__ . "/temp/" . $dir . "/manager", __DIR__ . "/temp/" . $dir . "/" . MGR_DIR);
        removeFolder(__DIR__ . "/temp/" . $dir . "/manager");
    }
    // echo __DIR__."/temp/".$dir."/".MGR_DIR;
}
copyFolder(__DIR__ . "/temp/" . $dir, __DIR__ . "/");
removeFolder(__DIR__ . "/temp");
unlink(__DIR__ . "/evo.zip");
unlink(__DIR__ . "/update.php");
header("Location: ' . constant('MODX_SITE_URL') . 'install/index.php?action=mode");');
                    if ($result === false) {
                        echo 'Update failed: cannot write to ' . MODX_BASE_PATH . 'update.php';
                    } else {
                        if ($type == 'commits') {
                            $versionGet = $commit;
                            $versionText = $version . '/' . $type . '/' . $branch . '/' . $commit;
                        } else {
                            $versionGet = $_SESSION['updateversion'];
                            $versionText = $_SESSION['updateversion'];
                        }
                        echo '<html><head></head><body><h2>Evolution Updater</h2>
                          <p>Downloading version: <strong>' . $versionText . '</strong>.</p>
                          <p>You will be redirected to the update wizard shortly.</p>
                          <p>Please wait...</p>
                          <script>window.location = "' . MODX_SITE_URL . 'update.php?version=' . $versionGet . '";</script>
                          </body></html>';
                    }
                }
                die();
                break;
        }
    }
}
