## 1. 自訂指令
#### 1.1 Permission
重新安裝所有角色與權限，當data-presets檔內有修改權限的話可用這個指令重新安裝，會將原本有的重新對應權限給角色

    permission:reinstall

## 2. 後台活動紀錄
#### 1.1 使用時間
若是執行修正時，當model存入資料庫之前，就需要引用活動紀錄的function，才能抓到前後對比紀錄

    舉例:
    $user->fill($data);
    ActionLog::create_log($user);
    $user->save();

## 3. 後台menu 建立流程
#### 1.
在config/menu.php中加入 menu 項目與參數

    type => 類型,
    title => 左側menu名稱,
    func_name => route name,
    icon => 使用圖標,
    permission => 權限規範,
    controller => 控制器,
    children => 子項目
#### 2.
建立menu 需要的 controller
#### 3.
在config/data-presets.php 中 permission 項目 加入menu 的權限資料
#### 4.
執行重新安裝權限指令

    php artisan permission:reinstall
#### 5.
開始正常執行

