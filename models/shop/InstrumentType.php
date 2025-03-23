<?php

enum InstrumentType: string
{
    // Keyboard instruments
    case Keyboard = 'keyboard';
    case Piano = 'piano';
    case DigitalPiano = 'digital_piano';
    case Synthesizer = 'synthesizer';
    case Organ = 'organ';
    case Accordion = 'accordion';
    case Keytar = 'keytar';
    
    // String instruments
    case Guitar = 'guitar';
    case AcousticGuitar = 'acoustic_guitar';
    case ElectricGuitar = 'electric_guitar';
    case ClassicalGuitar = 'classical_guitar';
    case Bass = 'bass';
    case Violin = 'violin';
    case Viola = 'viola';
    case Cello = 'cello';
    case DoubleBass = 'double_bass';
    case Harp = 'harp';
    case Ukulele = 'ukulele';
    case Banjo = 'banjo';
    case Mandolin = 'mandolin';
    
    // Wind instruments
    case Flute = 'flute';
    case Clarinet = 'clarinet';
    case Saxophone = 'saxophone';
    case Trumpet = 'trumpet';
    case Trombone = 'trombone';
    case FrenchHorn = 'french_horn';
    case Tuba = 'tuba';
    case Oboe = 'oboe';
    case Bassoon = 'bassoon';
    case Recorder = 'recorder';
    case Harmonica = 'harmonica';
    
    // Percussion instruments
    case Drum = 'drum';
    case DrumKit = 'drum_kit';
    case ElectronicDrumKit = 'electronic_drum_kit';
    case Cajon = 'cajon';
    case Bongo = 'bongo';
    case Conga = 'conga';
    case Djembe = 'djembe';
    case Tambourine = 'tambourine';
    case Xylophone = 'xylophone';
    case Marimba = 'marimba';
    case Vibraphone = 'vibraphone';
    case Cymbals = 'cymbals';
    case Triangle = 'triangle';
    
    // Electronic instruments
    case DJ = 'dj_equipment';
    case DrumMachine = 'drum_machine';
    case SamplingPad = 'sampling_pad';
    case MIDI = 'midi_controller';
    case LoopStation = 'loop_station';
    
    // Traditional/Folk instruments
    case Bagpipe = 'bagpipe';
    case Sitar = 'sitar';
    case Didgeridoo = 'didgeridoo';
    case Kalimba = 'kalimba';
    case PanFlute = 'pan_flute';
    
    // Orchestral accessories
    case Conductor = 'conductor_baton';
    case MusicStand = 'music_stand';
    
    // Other
    case Amplifier = 'amplifier';
    case Microphone = 'microphone';
}
