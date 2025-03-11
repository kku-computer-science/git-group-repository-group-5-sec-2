import { test, expect } from '@playwright/test';
import { waitForPageLoad, login } from './utils/utils';
// import { testData } from './test-data';
import path from 'path';

test.describe.serial("CREATE module",() => {
    // const baseURL = "http://cs05sec267.cpkkuhost.com";
    const baseURL = "http://127.0.0.1:8000"; 
    const username = "staff@gmail.com";
    const password = "123456789";
    var dashboardPage ;
    var uploadImg;
    const tags = "Wararat";
    const testData = require('./test-data.json');


    // setting default timeout
    test.beforeEach(async ({ page }) => {
        await page.setDefaultTimeout(60000); // Set timeout to 6 seconds
    });


    // UAT-sp3-005
    test("complete create highlight", async ({page}) => {
        

        // test case 1
        await test.step("TC1: Login Success", async () => {
            dashboardPage = await login(page, baseURL, username, password);
        })
        
    
        // test case 2
        await test.step("TC2 : navigate to setting highlight page", async () => {
            await dashboardPage.getByRole('link', { name: 'Highlight Setting' }).click();
            
            await waitForPageLoad(dashboardPage);
            
            const detailedPageURL = `${baseURL}/highlight`; 
            await expect(dashboardPage).toHaveURL(new RegExp(`${detailedPageURL}`)); 
        })

        
        // test case 3
        // await test.step("TC3 : create tags", async () => {
            
        //     //navigate to tags page
        //     await dashboardPage.getByRole('link', { name: '+ สร้าง Tags ใหม่' }).click();

        //     // fill tags field
        //     await dashboardPage.getByRole('textbox', { name: 'ชื่อแท็ก' }).click();
        //     await dashboardPage.getByRole('textbox', { name: 'ชื่อแท็ก' }).fill(tags)

        //     await dashboardPage.getByRole('button', { name: 'สร้าง' }).click();
        // });
        
        // test case 4
        await test.step("TC4 : create highlights", async () => {
            await dashboardPage.getByRole('link', { name: 'สร้าง Highlight ใหม่' }).click();
            // fill title field
            await dashboardPage.getByRole('textbox', { name: 'ชื่อ' }).click();
            await dashboardPage.getByRole('textbox', { name: 'ชื่อ' }).fill(testData.title);
            
            // fill detail field
            await dashboardPage.getByRole('textbox', { name: 'คำอธิบาย' }).click();
            await dashboardPage.getByRole('textbox', { name: 'คำอธิบาย' }).fill(testData.description);

            // upload cover image
            const pathImg = path.join('../image' ,testData.cover_img);

            // const fileChooserPromise = dashboardPage.waitForEvent('filechooser');
            // if (fileChooserPromise) {
            //     console.log(fileChooserPromise);
            // }
            // await dashboardPage.getByRole('textbox', { name: 'อัปโหลดภาพปก' }).click();
            // const fileChooser = await fileChooserPromise;
            // await fileChooser.setFiles(pathImg);



            await dashboardPage.getByRole('textbox', { name: 'อัปโหลดภาพปก' }).setInputFiles(pathImg);
            
            // await expect(dashboardPage.getByRole('textbox', { name: 'อัปโหลดภาพปก' })).toHaveValue(`C:\\fakepath\\2024-12-2-1733715590-1.png`);
            // await dashboardPage.waitForTimeout(5000);

            // await dashboardPage.getByRole('textbox', { name: 'อัปโหลดอัลบั้มภาพ' }).click();
            
            const imagePaths = testData.album_img.map((imageName) =>
                path.join('../image' , imageName)
            );
            await dashboardPage.getByRole('textbox', { name: 'อัปโหลดอัลบั้มภาพ' }).setInputFiles(imagePaths);
            await dashboardPage.waitForTimeout(10000);



            // const albumSelector = 'input[type="file"]'; // Replace with the actual selector for the file input

            // // Upload multiple images
            // await page.setInputFiles(albumSelector, imagePaths);
        });
    });
});