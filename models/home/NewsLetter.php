<?php

class NewsLetter
{
  public string $title;
  public string $summary;
  public ?string $targetUrl;
  public ?string $targetName;
  public string $bgUrl;

  public function __construct(string $title, string $summary, ?string $targetUrl, ?string $targetName, string $bgUrl)
  {
    $this->title = $title;
    $this->summary = $summary;
    $this->targetUrl = $targetUrl;
    $this->targetName = $targetName;
    $this->bgUrl = $bgUrl;
  }
}

class NewsLetterModel
{
  public function fetchAll(): array
  {
    return [
      new NewsLetter('Our Paths to Execellence', 'The Music Place offers a path to excellence that begins with fun! These paths for early childhood exploration, vocal, instrumental and special needs are each carefully designed to keep students inspired to enjoy music for a lifetime.', null, null, 'https://musicplace.com/images/Kids/PinkSocksTutu1000x667.jpg'),
      new NewsLetter('Early Childhood', 'AGES 1-6: Small, size-limited Family Classes with parents or caregivers (for ages 0-3) and small Early Music Awareness groups (for ages 3-6) delight the youngest students as they experience song, notes, instruments and other first steps on the exciting journey of learning music.', '#', 'Learn about these first steps...', 'https://musicplace.com/images/Classes/FamilyClass2_900x692Crop.jpg'),
      new NewsLetter('Instrumental', 'AGES 6 & UP: To be well-prepared for instrumental lessons, students survey 7-8 size-appropriate instruments and learn keyboard basics. Teachers help students find the most appropriate instrument on which to continue their music learning journey. Private Lessons are the final step!', '#', 'Explore instrumental options...', 'https://musicplace.com/images/Facilities/DadTeachesSon692x900.2.jpg'),
      new NewsLetter('Assessments', "AGES 3 & UP: Determine your child's readiness! Educational Specialists play games with kids to assess aptitudes and development. They can then advise you on the best starting point or next steps for your child. Perfect for those with Special Needs, too.", '#', 'Learn more about assessments...', 'https://musicplace.com/images/Instruments/iStock-EducationalSpecialistStudent_600x400.jpg'),
      new NewsLetter('Vocal', 'AGES 4 & UP: In "All Arts" (Vocal/Drama) classes, Vocal Ensembles and Private Lessons, singers develop skills in technique & performance. All styles and genres are offered and supported by frequent performance opportunities.', '#', 'Discover our singing path', 'https://musicplace.com/images/Vocal/VocalBoy-w-Umbrella_600x450.png'),
      new NewsLetter('Special Needs', 'BIRTH-ADULT: Board Certified Music Therapists offer private and small group therapy sessions for clients with special needs of all levels. For clients with sustained attention, adaptive music lessons focusing on learning to play specific instruments are also available.', '#', 'Explore our special needs programs', 'https://musicplace.com/images/Facilities/Special_Needs/IS_SN_HoldsUpVictoriousViolin_1000x667.jpg'),
    ];
  }
}
