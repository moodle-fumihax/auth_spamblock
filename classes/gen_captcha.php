<?php

namespace auth_spamblockbeta;

class gen_captcha{
    public static function gen_image($answer){
        //ファイルから直接アルファベット画像を読み込めないのでbase64から変換する
        $alphabets_img = base64_decode(self::gen_alphabets_img());
        $alphabets_img = imagecreatefromstring($alphabets_img);
        //アルファチャンネルを保存するための処理群
        //ブレンドモードを無効にする
        imagealphablending($alphabets_img, false);
        //完全なアルファチャネル情報を保存するフラグをonにする
        imagesavealpha($alphabets_img, true);

        $alphabets = range("A","Z");
        $answer_array = str_split($answer);

        //$ox = array_search($answer_array[0],$alphabets) * 40;
        //$alphabets_img = imagesetclip($alphabets_img,$ox,0,$ox+39,39);

        $width = 48*4+40;
        $result = imagecreatetruecolor($width,40);
        //アルファチャンネルを保存するための処理群
        //ブレンドモードを無効にする
        imagealphablending($result, false);
        //完全なアルファチャネル情報を保存するフラグをonにする
        imagesavealpha($result, true);
        //背景を設定（透明度100％）
        $bg = imagecolorallocatealpha($result,0,0,0,127);
        //背景を塗りつぶす
        imagefilledrectangle($result,0,0,$width,40,$bg);

        foreach($answer_array as $index => $ans){
            //echo $index.":".$ans."->".array_search($ans,$alphabets)."<br>";
            imagecopy(
                $result,
                $alphabets_img,
                $index * 48,
                0,
                array_search($ans,$alphabets) * 40,
                0,
                40,
                40
            );
        }

        ob_start();
        ImagePNG($result);
        $img = base64_encode(ob_get_contents());
        ob_end_clean();
        imagedestroy($result);

        return $img;
    }

    //base64であらかじめエンコードされた画像を返す（元データ：alphabets.png）
    static function gen_alphabets_img(){
        $img = "iVBORw0KGgoAAAANSUhEUgAABBAAAAAoCAYAAABHAwkjAAAMzklEQVR4Ae3BwY3kABDDQDL/oHUZ6CM0PN5zlUD4NNKFTyNd+PzP5FboZBM6+W3hltwKG3lWeDe5FT6fz/9KboWN3Aob6UInXdjIrbCRW+HFBMKnkS58GunC538mt0Inm9DJbwu35FbYyLPCu8mt8Pl8/ldyK2zkVthIFzrpwkZuhY3cCi8mED6NdOHTSBc+/zO5FTrZhE5+W7glt8JGnhXeTW6Fz+fzv5JbYSO3wka60EkXNnIrbORWeDGB8GmkC59GuvD5n8mt0MkmdPLbwi25FTbyrPBucit8Pp//ldwKG7kVNtKFTrqwkVthI7fCiwmETyNd+DTShc//TG6FTjahk98WbsmtsJFnhXeTW+Hz+fyv5FbYyK2wkS500oWN3AobuRVeTCB8GunCp5EufP5ncit0sgmd/LZwS26FjTwrvJvcCp/P538lt8JGboWNdKGTLmzkVtjIrfBiAuHTSBc+jXTh8z+TW6GTTejkt4Vbcits5Fnh3eRW+Hw+/yu5FTZyK2ykC510YSO3wkZuhRcTCJ9GuvBppAuf/5ncCp1sQie/LdySW2EjzwrvJrfC5/P5X8mtsJFbYSNd6KQLG7kVNnIrvJhA6ORW2MgmdNKFTp4VOrkVNvKs0MmzQifPCp3cCp1sQifvFjayCZ10oZNnhU660EkXbskmbORW2MitsJFbYSO3wkbeLXSyCZ3cChu5FTbShU660EkXOulCJ5vQSRc6eVbopBAIndwKG9mETrrQybNCJ7fCRp4VOnlW6ORZoZNboZNN6OTdwkY2oZMudPKs0EkXOunCLdmEjdwKG7kVNnIrbORW2Mi7hU42oZNbYSO3wka60EkXOulCJ13oZBM66UInzwqdFAKhk1thI5vQSRc6eVbo5FbYyLNCJ88KnTwrdHIrdLIJnbxb2MgmdNKFTp4VOulCJ124JZuwkVthI7fCRm6FjdwKG3m30MkmdHIrbORW2EgXOulCJ13opAudbEInXejkWaGTQiB0citsZBM66UInzwqd3AobeVbo5Fmhk2eFTm6FTjahk3cLG9mETrrQybNCJ13opAu3ZBM2cits5FbYyK2wkVthI+8WOtmETm6FjdwKG+lCJ13opAuddKGTTeikC508K3RSCIROboWNbEInXejkWaGTW2EjzwqdPCt08qzQya3QySZ08m5hI5vQSRc6eVbopAuddOGWbMJGboWN3AobuRU2cits5N1CJ5vQya2wkVthI13opAuddKGTLnSyCZ10oZNnhU4KgdDJrbCRTeikC508K3RyK2zkWaGTZ4VOnhU6uRU62YRO3i1sZBM66UInzwqddKGTLtySTdjIrbCRW2Ejt8JGboWNvFvoZBM6uRU2citspAuddKGTLnTShU42oZMudPKs0EkhEDq5FTayCZ10oZNnhU5uhY08K3TyrNDJs0Int0Inm9DJu4WNbEInXejkWaGTLnTShVuyCRu5FTZyK2zkVtjIrbCRdwudbEInt8JGboWNdKGTLnTShU660MkmdNKFTp4VOikEQie3wkY2oZMudPKs0MmtsJFnhU6eFTp5VujkVuhkEzp5t7CRTeikC508K3TShU66cEs2YSO3wkZuhY3cChu5FTbybqGTTejkVtjIrbCRLnTShU660EkXOtmETrrQybNCJ4VA+FySZ4VOboXPk6QL/zfZhE7eLWykC51sQifPCp10oZMubKQLnXRhI7fC3ya3wueSbEInm9DJrdBJFzrpQidd6KQLnXShk03o5Fmhk2eFTgYC4XNJnhU6uRU+T5Iu/N9kEzp5t7CRLnSyCZ08K3TShU66sJEudNKFjdwKf5vcCp9LsgmdbEInt0InXeikC510oZMudNKFTjahk2eFTp4VOhkIhM8leVbo5Fb4PEm68H+TTejk3cJGutDJJnTyrNBJFzrpwka60EkXNnIr/G1yK3wuySZ0sgmd3AqddKGTLnTShU660EkXOtmETp4VOnlW6GQgED6X5Fmhk1vh8yTpwv9NNqGTdwsb6UInm9DJs0InXeikCxvpQidd2Mit8LfJrfC5JJvQySZ0cit00oVOutBJFzrpQidd6GQTOnlW6ORZoZOBQPhckmeFTm6Fz5OkC/832YRO3i1spAudbEInzwqddKGTLmykC510YSO3wt8mt8LnkmxCJ5vQya3QSRc66UInXeikC510oZNN6ORZoZNnhU4GAuFzSZ4VOrkVPk+SLvzfZBM6ebewkS50sgmdPCt00oVOurCRLnTShY3cCn+b3AqfS7IJnWxCJ7dCJ13opAuddKGTLnTShU42oZNnhU6eFToZCITPJXlW6ORW+DxJuvB/k03o5N3CRrrQySZ08qzQSRc6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";
        
        return $img;
    }
}