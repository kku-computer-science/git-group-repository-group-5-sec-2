*** Settings ***
Documentation     This is a test suite for invalid editing a highlight
Resource          resource_setting_highlight.robot

*** Variables ***
${USERNAME}                staff@gmail.com
${PASSWORD}                123456789
${OLD_TITLE}               งานวิจัยดีเด่น
${NEW_TITLE}               บทความวิจัยได้รับการตีพิมพ์ในวารสารวิชาการระดับนานาชาติ
${NEW_DETAIL}              วิทยาลัยการคอมพิวเตอร์ มหาวิทยาลัยขอนแก่น ขอแสดงความยินดีกับ ศ. ดร.จักรชัย โสอินทร์ อ. ดร.ญานิกา คงโสรส อ. ดร.เพชร อิ่มทองคำ และ Mr.Chenset Kim เนื่องในโอกาสที่บทความวิจัยได้รับการตีพิมพ์ในวารสารวิชาการระดับนานาชาติ จำนวน 1 บทความวิจัย
${NEW_COVER_IMAGE_PATH}    ${CURDIR}\\highlight2.png
${NOT_IMAGE_FILE}          ${CURDIR}\\delete_highlight.robot
${IMAGE_PATH3}             ${CURDIR}\\image3.png
${IMAGE_PATH4}             ${CURDIR}\\image4.png
${IMAGE_PATH5}             ${CURDIR}\\image5.png
${IMAGE_PATH6}             ${CURDIR}\\image6.png
${TAG1}                    cp
${TAG2}                    Khamron
${TAG3}                    Chakchai
${TAG4}                    Yanika
${TAG5}                    Phet

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Go To Edit Highlight Page
    Go To Highlight Setting Page

Title Can Not Be Null
    Click Edit Highlight Button
    Input Title          ${EMPTY}
    Scroll To Bottom of Page
    Sleep    1s
    Submit Highlight Form
    Title Should Be    edit Highlight
    Scroll To Bottom of Page
    Sleep    1s
    Cancel Highlight Form

Detail Can Not Be Null
    Click Edit Highlight Button
    Input Detail     ${EMPTY}
    Scroll To Bottom of Page
    Sleep    1s
    Submit Highlight Form
    Title Should Be    edit Highlight
    Scroll To Bottom of Page
    Sleep    1s
    Cancel Highlight Form

Cover Image Can Be Only Image File
    Click Edit Highlight Button
    Input Cover Image    ${NOT_IMAGE_FILE}
    Scroll To Bottom of Page
    Sleep    1s
    Submit Highlight Form
    Title Should Be    edit Highlight
    Scroll To Bottom of Page
    Sleep    1s
    Cancel Highlight Form

Image Can Be Null
    Click Edit Highlight Button
    Scroll To Bottom of Page
    Delete All images
    Submit Highlight Form

Tag Can Be Null
    Click Edit Highlight Button
    Scroll To Bottom of Page
    Sleep    1s
    Select Tags          ${TAG1}    ${TAG2}
    Submit Highlight Form
    Title Should Be    Highlight
    Scroll Down
    Sleep    1s
    [Teardown]    Close Browser

*** Keywords ***
Click Edit Highlight Button
    Scroll Element Into View    //td[text()='${OLD_TITLE}']
    Click Element               //td[text()='${OLD_TITLE}']/following-sibling::td//a[@class='btn btn-warning btn-sm']  # click the edit button of the highlight we want to edit