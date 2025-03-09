import { test, expect } from '@playwright/test';
import { waitForPageLoad } from './utils/utils';

test.describe.serial("",() => {
    // const baseURL = "http://cs05sec267.cpkkuhost.com"; // Base URL for the site, adjust as needed
    const baseURL = "http://127.0.0.1:8000"; /// Base URL for the site, adjust as needed


    test.beforeEach(async ({ page }) => {
        await page.setDefaultTimeout(60000); // Set timeout to 6 seconds
    });

    // test case 1
    test("TC1:  Login Success", async (page) => {

    })
});