-- Migration: insert_instrument
-- Created at: 2025-03-28 08:15:06

-- Write your SQL here

INSERT INTO instrument_types (name, category) VALUES
-- Keyboard Instruments
('Digital Piano', 'keyboard'),
('Synthesizer', 'keyboard'),
('MIDI Keyboard', 'keyboard'),

-- String Instruments
('Acoustic Guitar', 'string'),
('Electric Guitar', 'string'),
('Bass Guitar', 'string'),
('Violin', 'string'),
('Ukulele', 'string'),

-- Wind Instruments
('Flute', 'wind'),
('Saxophone', 'wind'),
('Trumpet', 'wind'),
('Clarinet', 'wind'),

-- Percussion Instruments
('Drum Kit', 'percussion'),
('Cajon', 'percussion'),
('Electronic Drums', 'percussion'),
('Djembe', 'percussion'),

-- Electronic Instruments
('DJ Mixer', 'electronic'),
('Drum Machine', 'electronic'),
('Loop Station', 'electronic'),

-- Accessories
('Guitar Amplifier', 'accessory'),
('Microphone', 'accessory'),
('Music Stand', 'accessory');

INSERT INTO instruments (
    title, 
    type_id, 
    brand, 
    description, 
    price, 
    stock_quantity, 
    img_id, 
    serial_number,
    is_buyable,
    is_rentable
) VALUES 
-- Keyboard Instruments
(
    'Yamaha P-125 Digital Piano', 
    (SELECT id FROM instrument_types WHERE name = 'Digital Piano'), 
    'Yamaha', 
    'Compact digital piano with weighted keys and rich sound', 
    17500000, 
    10, 
    NULL, 
    'YAM-DIGI-P125-001',
    TRUE,
    FALSE
),
(
    'Korg Minilogue XD Synthesizer', 
    (SELECT id FROM instrument_types WHERE name = 'Synthesizer'), 
    'Korg', 
    'Powerful analog/digital hybrid synthesizer', 
    15000000, 
    5, 
    NULL, 
    'KOR-SYNTH-MINI-XD-001',
    TRUE,
    FALSE
),

-- String Instruments
(
    'Gibson Les Paul Standard Electric Guitar', 
    (SELECT id FROM instrument_types WHERE name = 'Electric Guitar'), 
    'Gibson', 
    'Iconic electric guitar with premium construction', 
    58000000, 
    3, 
    NULL, 
    'GIB-LES-STD-001',
    TRUE,
    FALSE
),
(
    'Fender Precision Bass', 
    (SELECT id FROM instrument_types WHERE name = 'Bass Guitar'), 
    'Fender', 
    'Classic bass guitar with punchy tone', 
    30000000, 
    4, 
    NULL, 
    'FEN-BASS-P-001',
    TRUE,
    FALSE
),

-- Wind Instruments
(
    'Yamaha YAS-280 Student Alto Saxophone', 
    (SELECT id FROM instrument_types WHERE name = 'Saxophone'), 
    'Yamaha', 
    'Excellent saxophone for students and beginners', 
    18500000, 
    6, 
    NULL, 
    'YAM-SAX-280-001',
    TRUE,
    TRUE
),

-- Percussion Instruments
(
    'Roland TD-17KVX Electronic Drum Kit', 
    (SELECT id FROM instrument_types WHERE name = 'Electronic Drums'), 
    'Roland', 
    'Advanced electronic drum kit with professional features', 
    39500000, 
    2, 
    NULL, 
    'ROL-EDRUM-17KVX-001',
    TRUE,
    FALSE
),

-- Electronic Instruments
(
    'Native Instruments Maschine MK3', 
    (SELECT id FROM instrument_types WHERE name = 'Drum Machine'), 
    'Native Instruments', 
    'Powerful drum machine and sampler', 
    14000000, 
    4, 
    NULL, 
    'NAT-MACH-MK3-001',
    TRUE,
    FALSE
),

-- Accessories
(
    'Shure SM58 Microphone', 
    (SELECT id FROM instrument_types WHERE name = 'Microphone'), 
    'Shure', 
    'Industry-standard vocal microphone', 
    2300000, 
    15, 
    NULL, 
    'SHU-MIC-SM58-001',
    TRUE,
    FALSE
);
