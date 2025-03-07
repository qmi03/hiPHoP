<?php

class PopularInstrument
{
  public array $paragraphs;
  public array $imageUrls;

  public function __construct(array $paragraphs, array $imageUrls)
  {
    $this->paragraphs = $paragraphs;
    $this->imageUrls = $imageUrls;
  }
}

class PopularInstrumentModel
{
  public function fetch(): PopularInstrument
  {
    return new PopularInstrument(
      ["Wouldn't your child love to join the thousands of others who have learned these (or a dozen other instruments) in this place where FUN is FIRST?"],
      ["https://musicplace.com/templates/rt_photon/custom/images/Instruments/Piano/SQ_PianoYamahaFreeCrop.jpg", "https://musicplace.com/templates/rt_photon/custom/images/Instruments/Guitar/SQ_GuitarsUse.jpg", "https://musicplace.com/images/Instruments/SQ_TrapCloseUp_400NoPurple_UN.jpg", "https://musicplace.com/templates/rt_photon/custom/images/Instruments/Violin/SQ_ViolinUse.jpg"],
    );
  }
}
