*** Settings ***
Documentation     This is a test suite for valid editing a highlight
Resource          resource_setting_highlight.robot

*** Variables ***
${USERNAME}                staff@gmail.com
${PASSWORD}                123456789
${OLD_TITLE}               งานวิจัยดีเด่น
${NEW_TITLE}               บทความวิจัยได้รับการตีพิมพ์ในวารสารวิชาการระดับนานาชาติ
${NEW_DETAIL}              วิทยาลัยการคอมพิวเตอร์ มหาวิทยาลัยขอนแก่น ขอแสดงความยินดีกับ ศ. ดร.จักรชัย โสอินทร์ อ. ดร.ญานิกา คงโสรส อ. ดร.เพชร อิ่มทองคำ และ Mr.Chenset Kim เนื่องในโอกาสที่บทความวิจัยได้รับการตีพิมพ์ในวารสารวิชาการระดับนานาชาติ จำนวน 1 บทความวิจัย
${NEW_COVER_IMAGE_PATH}    ${CURDIR}\\highlight2.png
${IMAGE_PATH3}             ${CURDIR}\\image3.png
${IMAGE_PATH4}             ${CURDIR}\\image4.png
${IMAGE_PATH5}             ${CURDIR}\\image5.png
${IMAGE_PATH6}             ${CURDIR}\\image6.png
${TAG3}                    Chakchai
${TAG4}                    Yanika
${TAG5}                    Phet

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Edit Highlight
    Go To Highlight Setting Page
    Click Edit Highlight Button
    Title Should Be    edit Highlight
    Input Title        ${NEW_TITLE}
    Input Detail       ${NEW_DETAIL}
    Scroll To Bottom of Page
    Input Cover Image  ${NEW_COVER_IMAGE_PATH}
    Input Images       ${IMAGE_PATH3}    ${IMAGE_PATH4}    ${IMAGE_PATH5}    ${IMAGE_PATH6}
    Select Tags        ${TAG3}    ${TAG4}    ${TAG5}
    Submit Highlight Form
    Scroll Element Into View    //td[text()='${NEW_TITLE}']
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Edit Highlight Button
    Scroll Element Into View    //td[text()='${OLD_TITLE}']
    Click Element               //td[text()='${OLD_TITLE}']/following-sibling::td//a[@class='btn btn-warning btn-sm']  # click the edit button of the highlight we want to edit
