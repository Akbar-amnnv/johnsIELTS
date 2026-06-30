<?php

namespace Database\Seeders;

use App\Models\Vocabulary;
use App\Models\VocabularyCategory;
use Illuminate\Database\Seeder;

class VocabularySeeder extends Seeder
{
    public function run(): void
    {
       $category = VocabularyCategory::firstOrCreate(
    ['slug' => 'from-reading-passages-10'],
    [
        'name' => 'From Reading Passages 10',
        'description' => 'Vocabulary collected from reading passages for IELTS preparation.',
        'is_active' => true,
    ]
);

$words = [

    ['word'=>'fortress','translation'=>'qal’a, istehkom','definition'=>'A large strong building or structure used for defense in war.','example'=>'The fortress protected the city from enemies.','difficulty'=>'medium'],

    ['word'=>'invisible','translation'=>'ko‘rinmas','definition'=>'Impossible to see.','example'=>'The stars became invisible behind the clouds.','difficulty'=>'easy'],

    ['word'=>'prevailing mood','translation'=>'ustun kayfiyat, hukmron ruhiyat','definition'=>'The general feeling shared by most people at a particular time.','example'=>'The prevailing mood in the office was optimistic.','difficulty'=>'hard'],

    ['word'=>'bizarre economics','translation'=>'g‘alati iqtisodiyot','definition'=>'A very strange or unusual economic situation or system.','example'=>'The country experienced bizarre economics during the crisis.','difficulty'=>'hard'],

    ['word'=>'exposed','translation'=>'oshkor bo‘lgan, himoyasiz qolgan','definition'=>'Not protected or left open to danger or public attention.','example'=>'The village was exposed to strong winds.','difficulty'=>'medium'],

    ['word'=>'outraged','translation'=>'qattiq g‘azablangan','definition'=>'Extremely shocked, angry, or offended.','example'=>'Citizens were outraged by the decision.','difficulty'=>'medium'],

    ['word'=>'states','translation'=>'davlatlar','definition'=>'Countries or political regions.','example'=>'Several states agreed to the treaty.','difficulty'=>'easy'],

    ['word'=>'inquiry','translation'=>'surishtiruv, tekshiruv','definition'=>'An official investigation or request for information.','example'=>'The police launched an inquiry into the accident.','difficulty'=>'medium'],

    ['word'=>'surreal world','translation'=>'g‘ayritabiiy, tushdek dunyo','definition'=>'A strange world that seems unreal or dream-like.','example'=>'The movie created a surreal world full of mystery.','difficulty'=>'hard'],

    ['word'=>'peculiar mystique','translation'=>'o‘ziga xos sirli joziba','definition'=>'A strange and special mysterious quality.','example'=>'The old castle had a peculiar mystique.','difficulty'=>'hard'],

    ['word'=>'lucrative associations','translation'=>'foydali, daromadli aloqalar','definition'=>'Relationships or connections that bring profit or money.','example'=>'The businessman developed lucrative associations abroad.','difficulty'=>'hard'],

    ['word'=>'threatened interests','translation'=>'xavf ostidagi manfaatlar','definition'=>'Benefits or advantages that are in danger.','example'=>'The reforms threatened powerful interests.','difficulty'=>'hard'],

    ['word'=>'spectacular anachronism','translation'=>'ajoyib, lekin eskirib qolgan narsa','definition'=>'Something impressive that belongs to an outdated time.','example'=>'The steam train looked like a spectacular anachronism.','difficulty'=>'hard'],

    ['word'=>'infrared','translation'=>'infraqizil','definition'=>'A type of radiation invisible to the human eye.','example'=>'Infrared cameras can detect heat.','difficulty'=>'medium'],

    ['word'=>'commence','translation'=>'boshlamoq','definition'=>'To begin or start.','example'=>'The meeting will commence at noon.','difficulty'=>'easy'],

    ['word'=>'grid','translation'=>'to‘r, tarmoq','definition'=>'A network of crossing lines or connected systems.','example'=>'The city uses a modern power grid.','difficulty'=>'medium'],

    ['word'=>'expanse','translation'=>'keng maydon, ulkan hudud','definition'=>'A wide open area or large stretch.','example'=>'They admired the vast expanse of desert.','difficulty'=>'medium'],

    ['word'=>'severe','translation'=>'jiddiy, og‘ir','definition'=>'Very serious, harsh, or intense.','example'=>'The country suffered severe floods.','difficulty'=>'easy'],

    ['word'=>'indication','translation'=>'belgi, ko‘rsatkich','definition'=>'A sign or signal that something exists or may happen.','example'=>'There was no indication of danger.','difficulty'=>'easy'],

    ['word'=>'contamination','translation'=>'ifloslanish, zaharlanish','definition'=>'The process of making something polluted or unsafe.','example'=>'Water contamination is a serious issue.','difficulty'=>'medium'],

    ['word'=>'foolproof','translation'=>'xatosiz ishlaydigan','definition'=>'Designed so that it cannot fail or be used wrongly.','example'=>'The system is simple and foolproof.','difficulty'=>'medium'],

    ['word'=>'to prove popular','translation'=>'ommabop bo‘lib chiqmoq','definition'=>'To become liked or accepted by many people.','example'=>'The new product proved popular among teenagers.','difficulty'=>'medium'],

    ['word'=>'bias','translation'=>'biryoqlama fikr, tarafkashlik','definition'=>'An unfair preference or opinion.','example'=>'The report showed clear political bias.','difficulty'=>'medium'],

    ['word'=>'distrust','translation'=>'ishonchsizlik','definition'=>'Lack of trust or confidence.','example'=>'There is growing distrust of the media.','difficulty'=>'medium'],

    ['word'=>'justify','translation'=>'oqlamoq, asoslamoq','definition'=>'To show or prove that something is right or reasonable.','example'=>'He tried to justify his actions.','difficulty'=>'medium'],

    ['word'=>'wariness stems','translation'=>'ehtiyotkorlik kelib chiqadi','definition'=>'Caution comes from a particular reason or experience.','example'=>'Their wariness stems from past failures.','difficulty'=>'hard'],

    ['word'=>'lobbying techniques','translation'=>'ta’sir o‘tkazish usullari','definition'=>'Methods used to influence decision-makers or authorities.','example'=>'Companies use lobbying techniques to affect policies.','difficulty'=>'hard'],

    ['word'=>'an upswing','translation'=>'o‘sish, ko‘tarilish','definition'=>'An increase or improvement in activity or success.','example'=>'The economy experienced an upswing last year.','difficulty'=>'medium'],

    ['word'=>'correlate','translation'=>'o‘zaro bog‘liq bo‘lmoq','definition'=>'To have a mutual connection or relationship.','example'=>'High stress levels correlate with poor sleep.','difficulty'=>'medium'],

    ['word'=>'likelihood','translation'=>'ehtimollik','definition'=>'The chance that something will happen.','example'=>'There is little likelihood of rain today.','difficulty'=>'medium'],

];


        foreach ($words as $item) {
            Vocabulary::updateOrCreate(
                [
                    'vocabulary_category_id' => $category->id,
                    'word' => $item['word'],
                ],
                [
                    'translation' => $item['translation'],
                    'definition' => $item['definition'],
                    'example' => $item['example'],
                    'difficulty' => $item['difficulty'],
                    'is_active' => true,
                ]
            );
        }
    }
}
