<?php

use App\CompanyWorkingType;
use App\FAQ;
use App\NumberOfEmployees;
use App\OpportunitySubtype;
use App\OpportunityType;
use App\UserOccupation;
use App\UserOcupationStudy;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RegionsTableSeeder::class);
        $this->call(MunicipalityTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);

        $nemp1 = new NumberOfEmployees([
            'min' => 1,
            'max' => 10,
        ]);

        $nemp2 = new NumberOfEmployees([
            'min' => 11,
            'max' => 50,
        ]);

        $nemp3 = new NumberOfEmployees([
            'min' => 51,
            'max' => 100,
        ]);

        $nemp1->save();
        $nemp2->save();
        $nemp3->save();

        $this->call(OpportunityStatusesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(OpportunitiesTableSeeder::class);
        $this->call(PendingOpportunityAttributesTableSeeder::class);
        $this->call(StaticDataSeeder::class);
        $this->call(ContactsTableSeeder::class);

        // Query Seeding
        $this->call(QueryQuestionTableSeeder::class);
        $this->call(QueryPropertyTableSeeder::class);
        $this->call(QueryUnattendedQuestionTableSeeder::class);
        $this->call(QueryUnattendedQuestionOptionTableSeeder::class);
        $this->call(QueryTableSeeder::class);

        // Query Answers Seeding
        $this->call(QueryMessagesTableSeeder::class);
        $this->call(QueryPropertyAnswerTableSeeder::class);
        $this->call(QueryQuestionAnswerTableSeeder::class);
        $this->call(QueryUnattendedMessageTableSeeder::class);
        $this->call(QueryUnattendedQuestionAnswerTableSeeder::class);
        $this->call(OgTagTableSeeder::class);

        // Opportunity Comments Seeding
        $this->call(OpportunityCommentsTableSeeder::class);
        $this->call(OpportunityCommentLikesTableSeeder::class);

        $this->call(DisabilityTableSeeder::class);
        $this->call(PresentationTableSeeder::class);
        $this->call(SlideTableSeeder::class);
        
        $this->call(UserDisabilityTableSeeder::class);

        // User Occupations
        $this->call(UserOcupationStudySeeder::class);
        $this->call(UserOcupationWorkSeeder::class);
        $this->call(UserOccupationSeeder::class);
        $this->call(UserEducationTableSeeder::class);

        // Company Working Type
        $this->call(CompanyStatusSeeder::class);
        $this->call(CompanyWorkingTypeSeeder::class);
        $this->call(CompanyWorkingSubtypeSeeder::class);

        $this->call(OpportunityTypesTableSeeder::class);
        $this->call(OpportunitySubtypesSeeder::class);

        $this->call(FAQSeeder::class);
        $this->call(MailTemplateSeeder::class);
    }
}
