<?php

namespace App\Models;

use CodeIgniter\Model;

class Checklistschema extends Model
{
    public function currentVersion(): array {
        return [
            "teachers" => [
                ["am_teacher", "AM Teacher"],
                ["second_teacher", "2nd Teacher"],
                ["pm_teacher", "PM Teacher"],
            ],
            "students" => [
                ["students_18", "18 mo"],
                ["students_2", "2 yr"],
                ["students_3", "3 yr"],
                ["students_4", "4 yr"],
                ["students_5", "5 yr"],
            ],
            "checklist_items" => [
                [
                    "section" => "Playground",
                    "shortcode" => "playground",
                    "icon" => "fa-solid fa-football",
                    "groups" => [
                        [
                            "title" => "Space yourself around outside on the playground, blacktop, play equipment; move around continuously throughout the duration of outdoor time.",
                            "inputs" => [
                                "Monitoring playground",
                                "Walk the perimeter to pick up debris before going out",
                                "Take fanny pack outside (tissues, gloves, ice pack, bandages)",
                                "Count children before going out & coming in",
                                "Body check completed upon coming in",
                                "Take walkies out & take one to the front desk",
                            ]
                        ]
                    ]
                ],
                [
                    "section" => "Body Checks",
                    "shortcode" => "body_checks",
                    "icon" => "fa-solid fa-child-reaching",
                    "groups" => [
                        [
                            "title" => "Make sure children's faces are clean at all times.",
                            "inputs" => [
                                "Arrival time check",
                                "Post breakfast/lunch face wiped",
                                "Post inside/outside play check",
                                "After nap check",
                                "Departure body/face check & shoe tie check",
                            ]
                        ]
                    ]
                ],
                [
                    "section" => "Cleaning",
                    "shortcode" => "cleaning",
                    "icon" => "fa-solid fa-spray-can-sparkles",
                    "groups" => [
                        [
                            "title" => "",
                            "inputs" => [
                                "Spray bottles are labeled and full",
                                "Toys cleaned and sanitized",
                                "Bathroom cleaned & sanitized at nap time",
                                "Remove floor items when cleaning bathroom floors",
                            ]
                        ],
                        [
                            "title" => "PM Checklist - prior to departure:",
                            "inputs" => [
                                "Toys returned to bins",
                                "Bleach & water",
                                "Dramatic play neat",
                                "Library books returned",
                                "Tables & chairs cleaned",
                                "Diaper Genie cleaned out",
                                "Computers & speakers off",
                                "Temperature set to 70°F",
                                "Doors & windows locked",
                                "Lights off",
                                "iPads returned and plugged in",
                                "Classrooms set up for success",
                                "No food or drink left in the classroom"
                            ]
                        ]
                    ]
                ],
                [
                    "section" => "Classroom",
                    "shortcode" => "classroom",
                    "icon" => "fa-solid fa-chalkboard-user",
                    "groups" => [
                        [
                            "title" => "",
                            "inputs" => [
                                "Cell phone is not visible in classroom",
                                "Classroom attendance completed",
                                "Toys cleaned and sanitized",
                            ]
                        ],
                        [
                            "title" => "Board info is current",
                            "inputs" => [
                                "Lesson plan up current; given to office on Thur.",
                                "Goals/objectives",
                                "Lunch menu posted holidays",
                                "Activities",
                                "All classroom materials are organized"
                            ]
                        ],
                        [
                            "title" => "Planning time used efficiently",
                            "inputs" => [
                                "Cleaning (cubbies, doorknobs, bathroom, floors)",
                                "Prep for next day success",
                                "Lesson plans complete for next week",
                                "Lillio report sent",
                                "Homework sent",
                                "Cots are 6ft child head to toe",
                                "Set day for room weekly room meetings",
                            ]
                        ],
                        [
                            "title" => "Scheduling",
                            "inputs" => [
                                "Following classroom schedule",
                            ]
                        ],
                        [
                            "title" => "Monitoring children",
                            "inputs" => [
                                "Children's clothes changed if wet or dirty",
                            ]
                        ],
                    ]
                ]
            ]
        ];
    }
}