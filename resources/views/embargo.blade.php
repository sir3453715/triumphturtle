@extends('layouts.app')

@section('content')
<div class="main-wrapper">
    <section class="banner-wrapper">
        <div class="banner container">
            <div><img src="/storage/image/embargo-icon.svg" alt="禁運標誌">
                <h1>禁運清單</h1>
            </div>
        </div>
    </section>
    <section id="embargo-page" class="container mt-5">
        <!-- list 1 -->
        <div class="list">
            <h2>食品及健康</h2>
        <div class="list-item">
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="每人每張轉運單最多可運 6 公斤以內的食品，該食品不能含有肉類成份。">
                <img src="/storage/image/embargo-icon/food-1.png" alt="其他食品">
                <p>其他食品（限量）</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="每人每張轉運單不能超過 36 瓶保健食品，每種保健食品上限為 12 瓶。">
                <img src="/storage/image/embargo-icon/food-2.png" alt="保健食品（限量）">
                <p>保健食品（限量）</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有供36個月以下嬰幼兒食用的配方粉，包括奶粉或豆奶粉等。">
                <img src="/storage/image/embargo-icon/food-3.png" alt="配方粉">
                <p>配方粉</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有種類的茶葉及茶葉產品，包括茶包、茶餅及散裝茶葉等。">
                <img src="/storage/image/embargo-icon/food-4.png" alt="茶葉">
                <p>茶葉</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有醫師處方及藥師指示藥品(內服及外用)，食藥署管制藥物及毒品。例如避孕藥、安眠藥、褪黑激素藥物、麻醉藥物、精神科藥物、大麻(大麻葉)、嗎啡、可卡因等。">
                <img src="/storage/image/embargo-icon/food-5.png" alt="處方藥品、管制藥品及毒品">
                <p>處方藥品、<br>管制藥品及毒品</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="任何置入人體內之侵入性醫療用品，醫療器材管理辦法之醫療器材。例如心電圖機、血氧偵測機、針筒、刺青針、隱形眼鏡、衛生棉條、人工皮及血糖針等。">
                <img src="/storage/image/embargo-icon/food-6.png" alt="侵入性或特定醫療用品">
                <p>侵入性或特定<br>醫療用品</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="任何肉類或含肉類成份之食品或食物，例如水產、生或熟肉類及其製品如肉醬及肉乾等">
                <img src="/storage/image/embargo-icon/food-7.png" alt="肉類及肉類製品">
                <p>肉類及肉類製品</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="可供寵物食用的乾糧、零食、保健品及其他相關製品，如罐頭及肉乾等。">
                <img src="/storage/image/embargo-icon/food-8.png" alt="所有寵物相關食品">
                <p>所有寵物相關食品</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="中央疫情指揮中心宣佈新制，9/16/2020起口罩改列為輸入管制物品。所有種類的口罩，包括醫用及非醫用的口罩將一律禁運。">
                <img src="/storage/image/embargo-icon/food-9.png" alt="口罩">
                <p>口罩</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="任何常溫下容易因溫度或壓力等不可控制因素變質，或需其他環境條件保存的食品，如新鮮蔬果(相關農產品)、奶類(含相關製品)、蛋類(含相關製品)等食品。">
                <img src="/storage/image/embargo-icon/food-10.png" alt="容易變質或需冷藏食品">
                <p>容易變質或需</br>冷藏食品</p>
            </div>
        </div>
        </div>

        <!-- list 2 -->
        <div class="list mt-5">
            <h2>自然、科學及科技</h2>
        <div class="list-item">
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="各種肥料、土壤及其他無法分辨成份的不明粉末。">
                <img src="/storage/image/embargo-icon/nature-1.png" alt="肥料、土壤及不明粉末">
                <p>肥料、土壤及<br>不明粉末</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有種植種子(蔬果種子、花卉種子、花卉種球)、新鮮植物、保鮮花、乾花、乾燥花、種子類香料(如大蒜、茴香籽、芫荽籽)、種子類中藥材等。">
                <img src="/storage/image/embargo-icon/nature-2.png" alt="種子、種球及植物花草">
                <p>種子、種球及<br>植物花草</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有動物或人類的任何部位，包括胚胎、器官、毛髮類（如毛皮、皮草及其製品）、蹄骨角類及其製品、屍體殘骸、化石及保育類相關製品等。">
                <img src="/storage/image/embargo-icon/nature-3.png" alt="屍骨、殘骸、毛皮及化石">
                <p>屍骨、殘骸、毛皮<br>及化石</p>
            </div>
        </div>
        </div>

           <!-- list 3 -->
           <div class="list mt-5">
            <h2>奢侈品及娛樂</h2>
        <div class="list-item">
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有香煙、雪茄、電子煙、煙草、無煙煙草產品、其相關商品及裝置配件（不含尼古丁成份均規範在內），例如點火器、水煙壺、茶葉彈、特殊煙彈、煙油及其吸食配件等等。">
                <img src="/storage/image/embargo-icon/luxury-1.png" alt="煙草及相關的裝置配件">
                <p>煙草及相關的<br>裝置配件</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="貴重名錶、珠寶飾品及珍貴古董文物等，單一貨件不可超過台幣3萬元，單張轉運單不得超過台幣5萬元。">
                <img src="/storage/image/embargo-icon/luxury-2.png" alt="貴重物品">
                <p>貴重物品</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有類型的彩票及博彩類配備，如賭博機器、賭桌、籌碼等。">
                <img src="/storage/image/embargo-icon/luxury-3.png" alt="指定博彩物品">
                <p>指定博彩物品</p>
            </div>
        </div>
        </div>

          <!-- list 4 -->
          <div class="list mt-5">
            <h2>特殊物品</h2>
        <div class="list-item">
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有酒精或含酒精成份的產品，如威士忌、水果酒、調理酒、清酒等。">
                <img src="/storage/image/embargo-icon/special-1.png" alt="酒精類">
                <p>酒精類</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有類型的儲值卡（SIM卡），例如預付儲值卡。">
                <img src="/storage/image/embargo-icon/special-2.png" alt="儲值卡">
                <p>儲值卡</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="各種現金、具有與金錢相同價值的物品及相關的偽造品，例如收藏類錢幣或郵票、現金券、禮品卡及有價證券。">
                <img src="/storage/image/embargo-icon/special-3.png" alt="現金及現金等價物">
                <p>現金及現金等價物</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="各種管制弓箭、弩及箭矢及相關配件等。">
                <img src="/storage/image/embargo-icon/special-4.png" alt="管制弩箭、弓箭">
                <p>管制弩箭、弓箭</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="各種類型的刀具及管制刀具配件，如野外求生刀、蝴蝶刀、斧頭、刀身及刀片等；餐刀及廚刀（刀鋒不能超過15公分）除外。">
                <img src="/storage/image/embargo-icon/special-5.png" alt="刀具及斧頭">
                <p>刀具及斧頭</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="例如香水、香膏、香薰、擴香、香水筆、浴廁香氛品等相關產品。">
                <img src="/storage/image/embargo-icon/special-6.png" alt="香氛類">
                <p>香氛類</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="電子元件、單獨寄遞的電池、單獨郵寄批量的乾電池、鋰電池及行動電源、發電機等，因無法通過安檢，一律禁運。">
                <img src="/storage/image/embargo-icon/special-7.png" alt="電池及充(蓄)電裝備">
                <p>電池及充(蓄)電裝備</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="受各國進出口管制貨品，及所有須由台灣衛生署、疾管局、防檢局、標準檢驗局、監理站等機關正式報關入境許可之貨品。如包括環境用藥（例如防蚊液、防蚊器等）、汽車相關零件、配件、安全座椅、木材等。">
                <img src="/storage/image/embargo-icon/special-8.png" alt="各國機關部門進出口許可">
                <p>各國機關部門<br>進出口許可</p>
            </div>
        </div>
        </div>

         <!-- list 5 -->
         <div class="list mt-5">
            <h2>危險品</h2>
        <div class="list-item">
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="各種磁鐵及帶有較強磁性的物件，此類可能影響飛機信號的物品均無法通過安檢，一律禁運。">
                <img src="/storage/image/embargo-icon/danger-1.png" alt="磁鐵">
                <p>磁鐵</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="任何在運輸途中可能會引起爆炸的物品，例如炸藥、煙花、爆竹、雷管、火冒等。">
                <img src="/storage/image/embargo-icon/danger-2.png" alt="爆炸品">
                <p>爆炸品</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有含毒性、生化武器、傳染性物質。例如毒藥、病原體、炭疽、醫藥用廢棄物、有害的廢料等。">
                <img src="/storage/image/embargo-icon/danger-3.png" alt="毒性、生化及傳染性物質">
                <p>毒性、生化<br>及傳染性物質</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="氣體、壓力罐及含有揮發氣體的貨品。例如壓縮氣體、乾冰、滅火器、蓄氣筒、充氣球體、救生器、易爆開的汽車安全氣囊、氣霧劑、氣體打火機、瓦斯氣瓶、燈泡、罐裝及碳酸飲料等。">
                <img src="/storage/image/embargo-icon/danger-4.png" alt="氣體及壓力罐">
                <p>氣體及壓力罐</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="直接接觸後，對人體、物品或運輸工具等造成不同程度損傷的化學物質。">
                <img src="/storage/image/embargo-icon/danger-5.png" alt="腐蝕性物質">
                <p>腐蝕性物質</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="放射性物質、氧化劑和有機過氧化物，例如鈾、鐳、過氧化氫、過氧化鈉、硝酸鉀、三氧化鉻等">
                <img src="/storage/image/embargo-icon/danger-6.png" alt="放射性物質">
                <p>放射性物質</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="所有槍械及相關配件、槍型物件以及軍事作戰（或類似用途）的設備，例如槍帶、水槍、氣槍、玩具槍、消防槍、子彈及彈殼等。">
                <img src="/storage/image/embargo-icon/danger-7.png" alt="槍械及相關配件">
                <p>槍械及相關配件</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="易燃固體、易燃液體、遇水釋放易燃氣體的物質及包裝有易燃字樣及圖示的貨品，例如生髮產品、炭、鈦粉、橡膠碎屑、安全火柴、磷、硫磺、指甲油、染髮劑及金屬粉末等。">
                <img src="/storage/image/embargo-icon/danger-8.png" alt="易燃物">
                <p>易燃物</p>
            </div>
        </div>
        </div>

              <!-- list 6 -->
              <div class="list mt-5">
            <h2>其他</h2>
        <div class="list-item">
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="受潮的包裹、有異常氣味泄露或散發的包裹。">
                <img src="/storage/image/embargo-icon/other-1.png" alt="受潮的包裹">
                <p>受潮的包裹</p>
            </div>
            <div class="list-item-box" data-toggle="tooltip" data-placement="top" title="其他法律禁止進口、出口的貨物、或其他航空危險品規定下的任何危險品、或可能造成運輸延誤的貨物。">
                <img src="/storage/image/embargo-icon/other-2.png" alt="其他">
                <p>其他</p>
            </div>
        </div>
        </div>

               <!-- list 6 -->
               <div class="list mt-5">
            <h2>寄送限制注意事項:</h2>
            <!-- 下面是使用wysiwyg編輯器-->
            <div class="edit-box mb-5">
                <div class="edit-content">
                    {!! app('Option')->send_content !!}
                </div>
            </div>

        </div>

    </section>
</div>
@endsection
