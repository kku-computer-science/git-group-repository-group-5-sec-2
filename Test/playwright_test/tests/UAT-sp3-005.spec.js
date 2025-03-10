import { test, expect } from '@playwright/test';
import { waitForPageLoad, login } from './utils/utils';

test.describe.serial("CREATE module",() => {
    // const baseURL = "http://cs05sec267.cpkkuhost.com";
    const baseURL = "http://127.0.0.1:8000"; 
    const username = "staff@gmail.com";
    const password = "123456789";
    var dashboardPage ;
    const tags = "";
    const highlight_title = "นักวิจัย มข. และบริษัทมิตรผล จับมือนำ AI คัดแยกพันธุ์อ้อยสู่เวทีนานาชาติ ในงาน ITEX 2025";
    const highlight_description = `
    วิทยาลัยการคอมพิวเตอร์ มหาวิทยาลัยขอนแก่น ขอแสดงความยินดีกับ รศ. ดร.วรารัตน์ สงฆ์แป้น และคณะทีมวิจัย จากบริษัท มิตรผลวิจัย พัฒนาอ้อยและน้ำตาล จำกัด ในผลงานเรื่อง “การพัฒนาแบบจำลองปัญญาประดิษฐ์การคัดแยกพันธุ์อ้อยด้วยการเรียนรู้เครื่องและการเรียนรู้เชิงลึก" ได้รับคัดเลือกจากสำนักงานการวิจัยแห่งชาติ (วช.) เข้าร่วมประกวดและจัดแสดงผลงานในงาน The 36th International Invention, Innovation & Technology Exhibition (ITEX 2025) ระหว่างวันที่ 29 – 31 พฤษภาคม 2568 ณ กรุงกัวลาลัมเปอร์ สหพันธรัฐมาเลเซีย

โดยคณะทีมวิจัยมีรายชื่อดังต่อไปนี้

1. รศ. ดร.วรารัตน์ สงฆ์แป้น วิทยาลัยการคอมพิวเตอร์ หัวหน้าโครงการ

2. ดร.วรวีรุกรณ์ วีระจิตต์ บริษัทมิตรผลวิจัย พัฒนาอ้อยและน้ำตาล จำกัด

3. นายเอกวัตร พันธุระ บริษัทมิตรผลวิจัย พัฒนาอ้อยและน้ำตาล จำกัด

4. นายณฤบดินทร์ ยินดี บริษัทมิตรผลวิจัย พัฒนาอ้อยและน้ำตาล จำกัด

โดยงานวิจัยและนวัตกรรมสิ่งประดิษฐ์นี้เป็นหนึ่งในโครงการที่ ทางมหาวิทยาลัยขอนแก่นและบริษัท มิตรผลวิจัย พัฒนาอ้อยและน้ำตาล จำกัด ได้มีความร่วมมือ MOU ในด้านการพัฒนาและสร้างผลงานวิจัย นวัตกรรมสิ่งประดิษฐ์ได้ให้เกิดประโยชน์ร่วมกัน
    `;
    const highlight_image = "";
    const highlight_video = "";

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
        await test.step("TC3 : create tags", async () => {
            await page1.getByRole('link', { name: 'สร้าง Tags ใหม่' }).click();
            await page1.getByRole('textbox', { name: 'Tag Name' }).click();
            await page1.getByRole('textbox', { name: 'Tag Name' }).fill(tags);
            await page1.getByRole('button', { name: 'สร้าง' }).click();
        });
        
        // test case 4
        await test.step("TC4 : create highlights", async () => {
            await page1.getByRole('link', { name: 'สร้าง Highlight ใหม่' }).click();
            
        });
    });
});