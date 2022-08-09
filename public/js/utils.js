function parseMarkToString(n) {
    if(n < 1.6) return 'A1';
    else if (n < 2.6) return 'A2'; 
    else if (n < 3.6) return 'B1'; 
    else if (n < 4.6) return 'B2'; 
    else if (n < 5.6) return 'C1'; 
    else if (n < 6.6) return 'C2'; 
}

function getMark(info) {
    let mark = {};
    for (const key in info) {
        if (Object.hasOwnProperty.call(info, key) && ( key.includes('area') || key.toLocaleLowerCase() == 'finalmark')) {
            mark[key] = info[key];         
        }
    }
    return mark; 
}

function getMarksByAreas(tests) {
    let areas = {};
    tests.forEach(test => {
        for (const key in test) {
            if (Object.hasOwnProperty.call(info, key) && ( key.includes('area') || key.toLocaleLowerCase() == 'finalmark')) {
                areas[key] = areas[key] ? areas[key] : [];
                areas[key] = info[key];         
            }
        }
    });
    
    return areas; 
}