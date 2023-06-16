// async wait return error: https://javascript.tutorialink.com/i-keep-getting-undefined-after-async-call-in-another-function/

const formatMoney = (price) => new Intl.NumberFormat('en-GB', { style: 'currency', currency: 'GBP' }).format(price);
// const getCategories = () => $.get($('#categoryRoute').val(), (category) => category);
const getColours = _ =>[
    'primary',
    'secondary',
    'success',
    'danger',
    'warning',
    'info',
    'light',
    'dark',
];

const randomColour = items => items[Math.floor(Math.random() * items.length)];

const handleError = (response) => {
    const errorStatus = response.status === 404;
    if (errorStatus) console.warn('could not find the specified text file location');
    return errorStatus;
};


const getCategories = async () => {

    try {
        const url = $('#categoryRoute').val();
        const response = await fetch(url);
        if(handleError(response)) return;
        return await response.json();
    } catch (e) {
        console.error(`There was an error fetching text file ${e.message}`);
    }
};
function isEmptyObject(o) {
    return Object.keys(o).every(function(x) {
        return o[x]===''||o[x]===null;  // or just "return o[x];" for falsy values
    });
}

const allCategories = async () => {
    const productDetails = [];
    const categories = await getCategories();

    categories.map(i => productDetails.push({ name: i.name, colour: randomColour(getColours())}))
    return productDetails;
    // categories.forEach(category =>{
    //     if
    // })
    // for (let i = 0; i < categories.length; i++) {
    //     const category = categories[i];
    //     if(ca)
        
    // }
    let coloursEmpty = categories.map(i => i.colour === null )

    console.warn(Boolean(coloursEmpty))

}
    // const categories = await getCategories();
    // return categories.map(category=> category['name'] );
    // // const productDetails = [];
    // // return getCategories().then(categories =>
    // //     categories.forEach(category => productDetails.push({
    // //         categoryName: category.name,
    // //         colour: randomColour(getColours())
    // //     })))


// const allCategories = () => {
//     const productDetails = [];
//     const categoryList = getCategories();
//     const random = () => randomColour(getColours())

//     categoryList.then(categories => {
//         for (let i = 0; i < categories.length; i++) {
//             const category = categories[i];
//             productDetails.push({
//                 name: category.name,
//                 colour: random()
//             })

//         }

//         console.log(productDetails)
//         return productDetails;
//     })
// }



// const allCategories2 = () => {
//     const productDetails = [];
//     const categoryList = getCategories();
//     const random = () => randomColour(getColours())

//     return categoryList.then(categories => {
//         return categories;
//         // for (let i = 0; i < categories.length; i++) {
//         //     const category = categories[i];
//         //     productDetails.push({
//         //         name: category.name,
//         //         colour: random()
//         //     })

//         // }

//         // console.log(productDetails)
//         // return productDetails;
//     })
// }



// const DEFAULT_CATEGORIES = p;

// console.warn({DEFAULT_CATEGORIES})

// https://contactmentor.com/find-object-in-array-of-objects/
const defaultCategoryColours = item => {
    // return ['danger', 'dark', 'info'];

    let tempColours = [];
    let itemCategories = item.category_list.split(',');

    allCategories().then(products=> {
    

        itemCategories.forEach(category  =>{

            const searchObject = products.find((product) => product.name === category);
            const productColour = searchObject.colour;
            tempColours.push(productColour)

            // let itemFound = searchIndex(products, category);
            // let categoryColour = itemFound.colour;

            // console.warn({categoryColour})
            // tempColours.push(categoryColour);

        })

    
    })

   

    // return getColours()

}


const renderUI = (categories, colours = getColours()) =>{

    let output = '';
    categories.forEach((category, i) => output += `<span class="badge text-bg-${colours[i] ?? 'warning'} ${i % 2 ? 'm-1' : ''}">${category}</span>`);
    return output;
}


const showCategories = (item) => {
    let categories = item.category_list.split(',');
    let coloursExists = item.category_colours
    let colours = item.category_colours ? item.category_colours.split(',') : defaultCategoryColours(item);
    if (!coloursExists) colours = defaultCategoryColours(item);
    if (coloursExists && colours.length != categories.length) colours = defaultCategoryColours(item);
    return renderUI(categories, colours)
};



const setMessage = (message, type = 'alert-danger') => `
<div class="alert ${type} mt-4" role="alert">
    ${message}
</div>
`;

export { formatMoney, showCategories, setMessage };