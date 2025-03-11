import { test, expect } from '@playwright/test';
import { waitForPageLoad, login, addTag } from './utils/utils';
import path from 'path';

test.describe.serial("CREATE module",() => {
    const baseURL = "http://cs05sec267.cpkkuhost.com";
    // const baseURL = "http://127.0.0.1:8000"; 
    const username = "thanlao@kku.ac.th";
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
        await test.step("TC2 : navigate to highlight setting page", async () => {
            await dashboardPage.getByRole('link', { name: 'Highlight Setting' }).click();
            
            await waitForPageLoad(dashboardPage);
            
            const detailedPageURL = `${baseURL}/highlight`; 
            await expect(dashboardPage).toHaveURL(new RegExp(`${detailedPageURL}`)); 
        })

        
        // test case 3
        await test.step("TC3 : create tags", async () => {
            
            //navigate to tags page
            await dashboardPage.getByRole('link', { name: 'New Tag' }).click();

            // fill tags field
            const tagName = dashboardPage.getByRole('textbox', { name: 'Tag Name' });
            await tagName.click();
            await tagName.fill(tags)

            await dashboardPage.getByRole('button', { name: 'Create' }).click();

            // check if tags is created
            await expect(dashboardPage.getByRole('cell', { name: 'Wararat' })).toBeVisible();

        });
        
        // test case 4
        await test.step("TC4 : create highlights", async () => {
            // button navigate to create highlight page
            await dashboardPage.getByRole('link', { name: 'New Highlight' }).click();

            // fill title field
            const titlefield = dashboardPage.getByRole('textbox', { name: 'Title' });
            await titlefield.click();
            await titlefield.fill(testData.title);
            
            // fill detail field
            const detailfield = dashboardPage.getByRole('textbox', { name: 'Description' });
            await detailfield.click();
            await detailfield.fill(testData.description);

            // upload cover image
            const pathImg = path.join('../image' ,testData.cover_img);
            const  coverImgfield = dashboardPage.getByRole('textbox', { name: 'Cover Image' });
            await coverImgfield.setInputFiles(pathImg);
            
            // upload album image 
            const imagePaths = testData.album_img.map((imageName) =>
                path.join('../image' , imageName)
            );
            const albumImgfield = dashboardPage.getByRole('textbox', { name: 'Image Album' });
            await albumImgfield.setInputFiles(imagePaths);
            // await dashboardPage.waitForTimeout(10000);

            // tag selection
            var tagsfield = dashboardPage.getByRole('textbox', { name: 'Tag' }) 
            
            await addTag(tagsfield, tags);
            await addTag(tagsfield, "cpkku");


            // submit form
            await dashboardPage.getByRole('button', { name: 'Create' }).click();

            await dashboardPage.waitForTimeout(5000);

        });
    });
});