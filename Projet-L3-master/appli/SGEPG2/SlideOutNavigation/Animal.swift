//
//  Animal.swift
//  SlideOutNavigation
//
//  Created by James Frost on 03/08/2014.
//  Copyright (c) 2014 James Frost. All rights reserved.
//

import UIKit

@objc
class Animal {
    
    let title: String
    let creator: String
    let image: UIImage?
 
    init(title: String, creator: String, image: UIImage?) {
        self.title = title
        self.creator = creator
        self.image = image
    }
    
    class func allCats() -> Array<Animal> {
        return [ Animal(title: "Sleeping Cat", creator: "papaija2008", image: UIImage(named: "ID-100113060.jpg")),
                 Animal(title: "Pussy Cat", creator: "Carlos Porto", image: UIImage(named: "ID-10022760.jpg")),
                 Animal(title: "Korat Domestic Cat", creator: "sippakorn", image: UIImage(named: "ID-10091065.jpg")),
                 Animal(title: "Tabby Cat", creator: "dan", image: UIImage(named: "ID-10047796.jpg")),
                 Animal(title: "Yawning Cat", creator: "dan", image: UIImage(named: "ID-10092572.jpg")),
                 Animal(title: "Tabby Cat", creator: "dan", image: UIImage(named: "ID-10041194.jpg")),
                 Animal(title: "Cat On The Rocks", creator: "Willem Siers", image: UIImage(named: "ID-10017782.jpg")),
                 Animal(title: "Brown Cat Standing", creator: "aopsan", image: UIImage(named: "ID-10091745.jpg")),
                 Animal(title: "Burmese Cat", creator: "Rosemary Ratcliff", image: UIImage(named: "ID-10056941.jpg")),
                 Animal(title: "Cat", creator: "dan", image: UIImage(named: "ID-10019208.jpg")),
                 Animal(title: "Cat", creator: "graur codrin", image: UIImage(named: "ID-10011404.jpg")) ]
    }

}