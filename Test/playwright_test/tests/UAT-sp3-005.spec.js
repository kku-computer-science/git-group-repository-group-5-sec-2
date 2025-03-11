import { test, expect } from '@playwright/test';
import { waitForPageLoad, login } from './utils/utils';

test.describe.serial("CREATE module",() => {
    const baseURL = "http://cs05sec267.cpkkuhost.com"; // Base URL for the site, adjust as needed
    // const baseURL = "http://127.0.0.1:8000"; /// Base URL for the site, adjust as needed
    const username = "staff@gmail.com";
    const password = "123456789";
    var dashboardPage ;

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
        await test.step("TC3 : create highlight", async () => {
            
        });
    });
});