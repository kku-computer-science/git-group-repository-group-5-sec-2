*** Settings ***
Documentation    A resource file for testing "Setting Highlight" page.
Library          SeleniumLibrary

*** Variables ***
${SERVER}              127.0.0.1:8000
# ${SERVER}            cs05sec267.cpkkuhost.com
${BROWSER}             Chrome
${LOGIN URL}           http://${SERVER}/login
${DELAY}               0.1s
${USERNAME}            staff@gmail.com
${PASSWORD}            123456789

${TITLE}               งานวิจัยดีเด่น
${DETAIL}              วิทยาลัยการคอมพิวเตอร์ มข. ขอแสดงความยินดีกับ นายภูมินทร์ ดวนขันธ์ ในโอกาสได้รับรางวัล วิทยานิพนธ์ดีเด่น ประจำปี 2567
${COVER_IMAGE_PATH}    ${CURDIR}\\highlight.png
${IMAGE_PATH1}         ${CURDIR}\\image1.png
${IMAGE_PATH2}         ${CURDIR}\\image2.png
${TAG1}                cp
${TAG2}                cpkku
${DELETE_BUTTON}    css=.btn-danger.btn-sm
${IMAGE_CONTAINER}    css=.position-relative

*** Keywords ***
Open Browser To Login Page
    Open Browser    ${LOGIN URL}    ${BROWSER}
    Maximize Browser Window            
    Set Selenium Speed    ${DELAY}
    Title Should Be       Login

Input Username
    [Arguments]    ${username}
    Input Text    id:username    ${username}

Input Password
    [Arguments]    ${password}
    Input Text    id:password    ${password}

Submit Credentials
    Click Button    xpath=//button[@type='submit']    # click the login button
    Title Should Be    Dashboard

Go To Highlight Setting Page
    Scroll Element Into View         xpath=//span[text()='Highlight Setting']
    Click Element                    xpath=//span[text()='Highlight Setting']
    Title Should Be                  Highlight

Input Title
    [Arguments]    ${TITLE}
    Input Text       //input[@name='title']          ${TITLE}

Input Detail
    [Arguments]    ${DETAIL}
    Input Text       //textarea[@name='detail']      ${DETAIL}

Input Cover Image
    [Arguments]    ${COVER_IMAGE_PATH}
    Choose File      //input[@name='cover_image']    ${COVER_IMAGE_PATH}

Input Images
    [Arguments]    @{IMAGE_PATHS}
    FOR    ${image_path}    IN    @{IMAGE_PATHS}
        Choose File    //input[@name='images[]']    ${image_path}
    END

Select Tags
    [Arguments]    @{TAGS}
    FOR    ${tag}    IN    @{TAGS}
        ${TAG_ID}    Get Element Attribute    //label[contains(text(),'${tag}')]   for  # get the id of the tag
        Execute JavaScript    document.getElementById('${TAG_ID}').click();            # click the tag
    END
Submit Highlight Form
    Click Button     //button[@type='submit']    # confirm the creation of the highlight

Cancel Highlight Form
    Click Link      //a[@class='btn btn-secondary']    # cancel the creation of the highlight

Click Highlight Create Button
    Click Link         //div[contains(@class, 'container mt-5')]//a[contains(@class, 'btn btn-primary mb-3')]  # click the create highlight button
    Title Should Be    create Highlight

Click Tag Create Button
    Click Link    //div[contains(@class, 'mb-3')]//a[contains(@class, 'btn btn-primary mt-2')]  # click the create tag button

Scroll Down
    ${document_height}=    Execute JavaScript    return document.body.scrollHeight
    ${middle_position}=    Evaluate    ${document_height} / 4
    Execute JavaScript    window.scrollTo(0, ${middle_position})

Scroll To Bottom of Page
    Execute JavaScript    window.scrollTo(0, document.body.scrollHeight);

Delete All images
    ${initial_count}=    Get Element Count    ${IMAGE_CONTAINER}
    Log    Initial image count: ${initial_count}
    
    # Delete each image and verify
    FOR    ${index}    IN RANGE    ${initial_count}
        ${current_count}=    Get Element Count    ${IMAGE_CONTAINER}
        Exit For Loop If    ${current_count} == 0
        
        Handle Delete Button Click    ${DELETE_BUTTON}
        Sleep    1s
        # Verify deletion
        ${new_count}=    Get Element Count    ${IMAGE_CONTAINER}
        Should Be True    ${new_count} < ${current_count}
        Log    Deleted image ${index + 1}. Remaining: ${new_count}
    END

Handle Delete Button Click
    [Arguments]    ${button}
    Wait Until Element Is Visible    ${button}
    Click Element    ${button}
    Sleep    1s
    Handle Alert    accept